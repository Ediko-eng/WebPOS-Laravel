<#
    Scheduler wrapper for the WebPOS database backup.

    The Windows Task Scheduler service on this machine does not execute
    tasks (they stay in "Queued" state), so the daily backup is driven by
    this loop instead.

    It runs the backup once at start-up and then every 24 hours. It is
    launched hidden from the Windows Start-up folder by
    "WebPOS Backup Loop.vbs".

    A named mutex guarantees only one instance runs at a time.
#>

$ErrorActionPreference = 'Continue'

$backupScript = Join-Path $PSScriptRoot 'backup-db.ps1'
$intervalSecs = 24 * 60 * 60
$logFile      = 'C:\wamp64\backups\backup.log'

function Write-Log([string]$Message) {
    $line = "[{0}] {1}" -f (Get-Date -Format 'yyyy-MM-dd HH:mm:ss'), $Message
    Add-Content -LiteralPath $logFile -Value $line -Encoding UTF8
}

# Only one instance at a time
$mutex           = New-Object System.Threading.Mutex($false, 'WebPOSBackupLoop')
$alreadyRunning  = $false

try {
    $alreadyRunning = -not $mutex.WaitOne(0)
} catch {
    Write-Log "Could not acquire the lock, continuing anyway: $($_.Exception.Message)"
}

if ($alreadyRunning) {
    Write-Log "Backup loop already running - exiting."
    exit 0
}

Write-Log "Backup loop started (every 24 hours)."

try {
    while ($true) {
        try {
            if (Test-Path -LiteralPath $backupScript) {
                & powershell -NoProfile -ExecutionPolicy Bypass -File $backupScript | Out-Null
                Write-Log "Backup cycle finished."
            } else {
                Write-Log "ERROR: backup script not found at $backupScript"
            }
        } catch {
            Write-Log "ERROR during backup cycle: $($_.Exception.Message)"
        }

        Start-Sleep -Seconds $intervalSecs
    }
}
catch {
    Write-Log "Backup loop terminated: $($_.Exception.Message)"
}
finally {
    Write-Log "Backup loop stopped."
    try { $mutex.ReleaseMutex() } catch { }
    $mutex.Dispose()
}

<#
    Daily backup for the WebPOS database (db_codinglinepos).

    Creates a .sql dump in the backup folder, compresses it when 7-Zip is
    available, and removes dumps older than the retention period.

    Credentials live in a MySQL option file (C:\wamp64\backups\my.cnf) so the
    password never appears on the command line and mysqldump stays quiet.

    Run manually:  powershell -ExecutionPolicy Bypass -File backup-db.ps1
    Scheduled via Windows Task Scheduler (see README).
#>

[CmdletBinding()]
param(
    [string]$Database   = 'db_codinglinepos',
    [string]$BackupDir  = 'C:\wamp64\backups\db',
    [string]$OptionFile = 'C:\wamp64\backups\my.cnf',
    [int]   $KeepDays   = 30
)

$ErrorActionPreference = 'Continue'

$MySqlDump = 'C:\wamp64\bin\mysql\mysql9.1.0\bin\mysqldump.exe'
$SevenZip  = 'C:\Program Files\7-Zip\7z.exe'
$LogFile   = 'C:\wamp64\backups\backup.log'

function Write-Log([string]$Message) {
    $line = "[{0}] {1}" -f (Get-Date -Format 'yyyy-MM-dd HH:mm:ss'), $Message
    Write-Output $line
    Add-Content -LiteralPath $LogFile -Value $line -Encoding UTF8
}

Write-Log "Backup starting (database: $Database)"

if (-not (Test-Path -LiteralPath $MySqlDump)) {
    Write-Log "ERROR: mysqldump not found at $MySqlDump"
    exit 1
}

if (-not (Test-Path -LiteralPath $OptionFile)) {
    Write-Log "ERROR: MySQL option file not found at $OptionFile"
    exit 1
}

if (-not (Test-Path -LiteralPath $BackupDir)) {
    New-Item -ItemType Directory -Path $BackupDir -Force | Out-Null
}

$stamp   = Get-Date -Format 'yyyy-MM-dd_HHmm'
$sqlFile = Join-Path $BackupDir "pos_$stamp.sql"
$gzFile  = "$sqlFile.gz"

# Dump with a single transaction so InnoDB tables stay consistent.
$arguments = @(
    "--defaults-extra-file=$OptionFile"
    '--single-transaction'
    '--routines'
    '--triggers'
    '--default-character-set=utf8mb4'
    "--result-file=$sqlFile"
    $Database
)

& $MySqlDump @arguments 2>&1 | ForEach-Object { if ($_ -and "$_".Trim()) { Write-Log "mysqldump: $_" } }

$exitCode = $LASTEXITCODE

if ($exitCode -ne 0) {
    Write-Log "ERROR: mysqldump failed with exit code $exitCode"
    exit $exitCode
}

if (-not (Test-Path -LiteralPath $sqlFile)) {
    Write-Log "ERROR: dump file was not created: $sqlFile"
    exit 1
}

$sizeKb = [math]::Round((Get-Item -LiteralPath $sqlFile).Length / 1KB, 1)
Write-Log "Dump created: $sqlFile ($sizeKb KB)"

# Compress when 7-Zip is available, otherwise keep the plain .sql
if (Test-Path -LiteralPath $SevenZip) {
    & $SevenZip a -tzip -mx=5 "$gzFile" "$sqlFile" | Out-Null
    if ($LASTEXITCODE -eq 0 -and (Test-Path -LiteralPath $gzFile)) {
        Remove-Item -LiteralPath $sqlFile -Force
        $sizeKb = [math]::Round((Get-Item -LiteralPath $gzFile).Length / 1KB, 1)
        Write-Log "Compressed:  $gzFile ($sizeKb KB)"
    }
}

# Rotate: remove dumps older than the retention period
$cutoff  = (Get-Date).AddDays(-$KeepDays)
$removed = 0
Get-ChildItem -LiteralPath $BackupDir -Filter 'pos_*.sql*' -ErrorAction SilentlyContinue |
    Where-Object { $_.LastWriteTime -lt $cutoff } |
    ForEach-Object {
        Remove-Item -LiteralPath $_.FullName -Force
        $removed++
    }

if ($removed -gt 0) {
    Write-Log "Rotation: removed $removed dump(s) older than $KeepDays days"
}

Write-Log "Backup finished successfully"
exit 0

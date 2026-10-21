<#
    Open the WebPOS in three browser windows at the same time, each logged
    in as a different user.

    Each browser has its own cookie jar, so the three sessions do not
    overwrite each other:

      1. Chrome  (default profile)          -> Administrator
      2. Edge                                -> Supervisor
      3. Chrome  (separate profile folder)  -> Operator

    Usage:  powershell -ExecutionPolicy Bypass -File open-three-users.ps1
#>

$ErrorActionPreference = 'Continue'

$BaseUrl = 'http://localhost/WebPOS-Laravel'

$Chrome = 'C:\Program Files\Google\Chrome\Application\chrome.exe'
$Edge   = 'C:\Program Files (x86)\Microsoft\Edge\Application\msedge.exe'

# Separate profile folder for the third window so it has its own cookies
$OperatorProfile = Join-Path $env:LOCALAPPDATA 'WebPOS-Chrome-Operator'

function Open-Browser($exe, $url, $profilePath) {
    if (-not (Test-Path -LiteralPath $exe)) {
        Write-Output "SKIP: browser not found -> $exe"
        return
    }

    if ($profilePath) {
        if (-not (Test-Path -LiteralPath $profilePath)) {
            New-Item -ItemType Directory -Path $profilePath -Force | Out-Null
        }
        Start-Process -FilePath $exe -ArgumentList "--user-data-dir=`"$profilePath`"", "--new-window", $url
    } else {
        Start-Process -FilePath $exe -ArgumentList "--new-window", $url
    }
}

Write-Output "Opening three WebPOS sessions..."
Write-Output ""

Open-Browser $Chrome "$BaseUrl/login?u=ediko" $null
Start-Sleep -Milliseconds 800

Open-Browser $Edge   "$BaseUrl/login?u=riana" $null
Start-Sleep -Milliseconds 800

Open-Browser $Chrome "$BaseUrl/login?u=fabio" $OperatorProfile

Write-Output ""
Write-Output "  1. Chrome  (default profile)  -> ediko   (Administrator)"
Write-Output "  2. Edge                      -> riana   (Supervisor)"
Write-Output "  3. Chrome  (separate profile) -> fabio   (Operator)"
Write-Output ""
Write-Output "Type the password for each one to sign in."
Write-Output "Passwords: C:\wamp64\backups\WebPOS-credentials.txt"

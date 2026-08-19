# Restores files from the latest pre-prompt backup pointed to by LATEST.txt
$root = Split-Path -Parent $MyInvocation.MyCommand.Path
$repoRoot = Resolve-Path (Join-Path $root "..")
$latestFile = Join-Path $root "LATEST.txt"
if (-not (Test-Path $latestFile)) {
    Write-Error "No LATEST.txt found. Nothing to revert."
    exit 1
}
$backupRel = (Get-Content $latestFile -Raw).Trim()
$backupDir = if ([System.IO.Path]::IsPathRooted($backupRel)) { $backupRel } else { Join-Path $repoRoot $backupRel }
if (-not (Test-Path $backupDir)) {
    Write-Error "Backup folder not found: $backupDir"
    exit 1
}
Get-ChildItem $backupDir -Recurse -File | Where-Object { $_.Name -ne "MANIFEST.txt" } | ForEach-Object {
    $rel = $_.FullName.Substring($backupDir.Length).TrimStart('\', '/')
    $dest = Join-Path $repoRoot $rel
    New-Item -ItemType Directory -Force -Path (Split-Path $dest) | Out-Null
    Copy-Item $_.FullName $dest -Force
    Write-Output "Restored: $rel"
}
Write-Output "Revert complete from: $backupDir"

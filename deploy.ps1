# Deployment script pentru Conectica IT - Windows PowerShell Version
# Automatizează procesul de deployment la Hostico

Write-Host "🚀 Starting deployment process..." -ForegroundColor Green

# Check if we're in a git repository
if (-not (Test-Path ".git")) {
    Write-Host "❌ Error: Not in a git repository" -ForegroundColor Red
    exit 1
}

# Check for uncommitted changes
$gitStatus = git status --porcelain
if ($gitStatus) {
    Write-Host "⚠️  Warning: You have uncommitted changes" -ForegroundColor Yellow
    Write-Host "Uncommitted files:"
    git status --short
    Write-Host ""
    $continue = Read-Host "Do you want to continue anyway? (y/N)"
    if ($continue -notmatch "^[Yy]$") {
        Write-Host "❌ Deployment cancelled" -ForegroundColor Red
        exit 1
    }
}

# Get current commit info
$commit = git rev-parse --short HEAD
$branch = git branch --show-current
$message = git log -1 --pretty=format:"%s"

Write-Host "📝 Current commit: $commit" -ForegroundColor Cyan
Write-Host "🌿 Branch: $branch" -ForegroundColor Cyan
Write-Host "💬 Message: $message" -ForegroundColor Cyan
Write-Host ""

# Push to GitHub
Write-Host "📤 Pushing to GitHub..." -ForegroundColor Yellow
try {
    git push origin $branch
    if ($LASTEXITCODE -eq 0) {
        Write-Host "✅ Successfully pushed to GitHub" -ForegroundColor Green
    } else {
        throw "Git push failed"
    }
} catch {
    Write-Host "❌ Failed to push to GitHub" -ForegroundColor Red
    exit 1
}

Write-Host ""
Write-Host "🎉 Deployment completed!" -ForegroundColor Green
Write-Host "🔗 Your site should be updated at: https://conectica-it.ro" -ForegroundColor Green
Write-Host "🛠️  Admin panel: https://conectica-it.ro/admin/" -ForegroundColor Green
Write-Host ""
Write-Host "💡 Note: It may take a few minutes for Hostico to deploy the changes." -ForegroundColor Yellow

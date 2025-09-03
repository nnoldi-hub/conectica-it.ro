#!/bin/bash
# Emergency Manual Deployment Script
# Use when Hostico auto-deployment is stuck

echo "🚨 Emergency Manual Deployment Starting..."

# Colors
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m'

# Repository info
REPO_PATH="/home/ylcqhxpa/repositories/conectica-it.ro"
WEB_PATH="/home/ylcqhxpa/public_html"
BACKUP_PATH="/home/ylcqhxpa/backup-$(date +%Y%m%d-%H%M%S)"

echo -e "${YELLOW}📂 Creating backup...${NC}"
if [ -d "$WEB_PATH" ]; then
    cp -r "$WEB_PATH" "$BACKUP_PATH"
    echo -e "${GREEN}✅ Backup created at: $BACKUP_PATH${NC}"
fi

echo -e "${YELLOW}📥 Pulling latest changes...${NC}"
cd "$REPO_PATH"
git pull origin main

echo -e "${YELLOW}🚀 Deploying files...${NC}"
# Copy all files except .git
rsync -av --exclude='.git' "$REPO_PATH/" "$WEB_PATH/"

echo -e "${YELLOW}🔐 Setting permissions...${NC}"
chmod -R 755 "$WEB_PATH"
chmod 644 "$WEB_PATH/.htaccess"
chmod 600 "$WEB_PATH/config/database.php"

echo -e "${GREEN}🎉 Manual deployment completed!${NC}"
echo -e "${GREEN}🔗 Check: https://conectica-it.ro${NC}"
echo -e "${GREEN}🛠️  Admin: https://conectica-it.ro/admin/${NC}"

echo -e "${YELLOW}📋 Files deployed:${NC}"
ls -la "$WEB_PATH" | head -10

#!/bin/bash

# Deployment script pentru Conectica IT
# Automatizează procesul de deployment la Hostico

echo "🚀 Starting deployment process..."

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Check if we're in a git repository
if ! git rev-parse --git-dir > /dev/null 2>&1; then
    echo -e "${RED}❌ Error: Not in a git repository${NC}"
    exit 1
fi

# Check for uncommitted changes
if ! git diff-index --quiet HEAD --; then
    echo -e "${YELLOW}⚠️  Warning: You have uncommitted changes${NC}"
    echo "Uncommitted files:"
    git diff --name-only
    echo ""
    read -p "Do you want to continue anyway? (y/N): " -n 1 -r
    echo
    if [[ ! $REPLY =~ ^[Yy]$ ]]; then
        echo -e "${RED}❌ Deployment cancelled${NC}"
        exit 1
    fi
fi

# Get current commit info
COMMIT=$(git rev-parse --short HEAD)
BRANCH=$(git branch --show-current)
MESSAGE=$(git log -1 --pretty=format:"%s")

echo -e "${GREEN}📝 Current commit: $COMMIT${NC}"
echo -e "${GREEN}🌿 Branch: $BRANCH${NC}"
echo -e "${GREEN}💬 Message: $MESSAGE${NC}"
echo ""

# Push to GitHub
echo -e "${YELLOW}📤 Pushing to GitHub...${NC}"
if git push origin $BRANCH; then
    echo -e "${GREEN}✅ Successfully pushed to GitHub${NC}"
else
    echo -e "${RED}❌ Failed to push to GitHub${NC}"
    exit 1
fi

echo ""
echo -e "${GREEN}🎉 Deployment completed!${NC}"
echo -e "${GREEN}🔗 Your site should be updated at: https://conectica-it.ro${NC}"
echo -e "${GREEN}🛠️  Admin panel: https://conectica-it.ro/admin/${NC}"
echo ""
echo -e "${YELLOW}💡 Note: It may take a few minutes for Hostico to deploy the changes.${NC}"

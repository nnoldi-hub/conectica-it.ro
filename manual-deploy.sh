#!/bin/bash

# Manual deployment script for Hostico
# Upload this file to your home directory and run it via Terminal in cPanel

echo "Starting manual deployment..."

# Set deployment path
DEPLOYPATH="/home/ylcghxpa/public_html"

# Create backup
if [ -d "$DEPLOYPATH" ]; then
    echo "Creating backup..."
    cp -r $DEPLOYPATH ${DEPLOYPATH}_backup_$(date +%Y%m%d_%H%M%S)
fi

# Copy files from git repository to public_html
echo "Copying files..."
cp -r /home/ylcghxpa/repositories/conectica-it.ro/* $DEPLOYPATH/

# Set proper permissions
echo "Setting permissions..."
find $DEPLOYPATH -type d -exec chmod 755 {} \;
find $DEPLOYPATH -type f -exec chmod 644 {} \;

# Make admin and config directories more secure
chmod 750 $DEPLOYPATH/admin/
chmod 750 $DEPLOYPATH/config/

echo "Deployment completed!"
echo "Visit: https://conectica-it.ro to verify"
echo "Check diagnostic: https://conectica-it.ro/diagnostic.php"

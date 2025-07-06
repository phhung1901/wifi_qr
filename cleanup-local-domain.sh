#!/bin/bash

# WiFi QR Local Domain Cleanup Script
# This script removes wifiqr.net domain configuration

echo "🧹 Cleaning up wifiqr.net domain configuration..."

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

print_status() {
    echo -e "${BLUE}ℹ️  $1${NC}"
}

print_success() {
    echo -e "${GREEN}✅ $1${NC}"
}

print_warning() {
    echo -e "${YELLOW}⚠️  $1${NC}"
}

print_error() {
    echo -e "${RED}❌ $1${NC}"
}

# Confirm cleanup
echo -e "${YELLOW}⚠️  This will remove all wifiqr.net configuration.${NC}"
read -p "Are you sure you want to continue? (y/N): " -n 1 -r
echo
if [[ ! $REPLY =~ ^[Yy]$ ]]; then
    echo "Cleanup cancelled."
    exit 0
fi

# Remove from /etc/hosts
print_status "Removing domain from /etc/hosts..."
sudo sed -i '/wifiqr\.local/d' /etc/hosts
print_success "Domain removed from /etc/hosts"

# Disable and remove Nginx site
print_status "Removing Nginx configuration..."
sudo rm -f /etc/nginx/sites-enabled/wifiqr.net
sudo rm -f /etc/nginx/sites-available/wifiqr.net
print_success "Nginx configuration removed"

# Remove SSL certificates (if they exist)
if [ -f "/etc/ssl/certs/wifiqr.net.crt" ]; then
    print_status "Removing SSL certificates..."
    sudo rm -f /etc/ssl/certs/wifiqr.net.crt
    sudo rm -f /etc/ssl/private/wifiqr.net.key
    print_success "SSL certificates removed"
fi

# Remove log files
print_status "Removing log files..."
sudo rm -f /var/log/nginx/wifiqr.net_error.log
sudo rm -f /var/log/nginx/wifiqr.net_access.log
print_success "Log files removed"

# Test Nginx configuration
print_status "Testing Nginx configuration..."
if sudo nginx -t; then
    print_success "Nginx configuration is valid"

    # Restart Nginx
    print_status "Restarting Nginx..."
    sudo systemctl restart nginx
    print_success "Nginx restarted successfully"
else
    print_error "Nginx configuration has errors after cleanup"
fi

print_success "Cleanup completed successfully!"
echo ""
echo -e "${GREEN}🎉 wifiqr.net domain has been removed.${NC}"
echo -e "${BLUE}The WiFi QR Generator is still available via:${NC}"
echo "   - http://localhost:8001 (if Laravel dev server is running)"
echo "   - Direct IP access if configured"

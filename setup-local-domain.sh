#!/bin/bash

# WiFi QR Local Domain Setup Script
# This script sets up wifiqr.local domain for local development

echo "🚀 Setting up wifiqr.local domain..."

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Check if running as root
if [[ $EUID -eq 0 ]]; then
   echo -e "${RED}❌ This script should not be run as root${NC}"
   echo "Please run without sudo. The script will ask for sudo when needed."
   exit 1
fi

# Function to print colored output
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

# Check if Nginx is installed
if ! command -v nginx &> /dev/null; then
    print_error "Nginx is not installed. Please install Nginx first:"
    echo "sudo apt update && sudo apt install nginx"
    exit 1
fi

# Check if PHP-FPM is installed
if ! systemctl is-active --quiet php8.2-fpm; then
    print_warning "PHP 8.2-FPM is not running. Checking for other PHP versions..."
    
    # Check for other PHP versions
    for version in 8.3 8.1 8.0 7.4; do
        if systemctl is-active --quiet php${version}-fpm; then
            print_status "Found PHP ${version}-FPM running"
            # Update nginx config to use the correct PHP version
            sed -i "s/php8.2-fpm/php${version}-fpm/g" nginx-wifiqr.conf
            break
        fi
    done
fi

# Step 1: Add domain to /etc/hosts
print_status "Adding wifiqr.local to /etc/hosts..."
if ! grep -q "wifiqr.local" /etc/hosts; then
    echo "127.0.0.1    wifiqr.local www.wifiqr.local" | sudo tee -a /etc/hosts
    print_success "Domain added to /etc/hosts"
else
    print_warning "Domain already exists in /etc/hosts"
fi

# Step 2: Copy Nginx configuration
print_status "Setting up Nginx configuration..."
sudo cp nginx-wifiqr.conf /etc/nginx/sites-available/wifiqr.local

# Step 3: Enable the site
print_status "Enabling Nginx site..."
sudo ln -sf /etc/nginx/sites-available/wifiqr.local /etc/nginx/sites-enabled/

# Step 4: Test Nginx configuration
print_status "Testing Nginx configuration..."
if sudo nginx -t; then
    print_success "Nginx configuration is valid"
else
    print_error "Nginx configuration has errors. Please check the config file."
    exit 1
fi

# Step 5: Set proper permissions
print_status "Setting proper permissions..."
sudo chown -R www-data:www-data /var/www/phamhung/wifi_qr/storage
sudo chown -R www-data:www-data /var/www/phamhung/wifi_qr/bootstrap/cache
sudo chmod -R 775 /var/www/phamhung/wifi_qr/storage
sudo chmod -R 775 /var/www/phamhung/wifi_qr/bootstrap/cache

# Step 6: Restart services
print_status "Restarting Nginx..."
sudo systemctl restart nginx

if sudo systemctl is-active --quiet nginx; then
    print_success "Nginx restarted successfully"
else
    print_error "Failed to restart Nginx"
    exit 1
fi

# Step 7: Check Laravel configuration
print_status "Checking Laravel configuration..."
cd /var/www/phamhung/wifi_qr

# Generate app key if not exists
if ! grep -q "APP_KEY=base64:" .env 2>/dev/null; then
    print_status "Generating Laravel application key..."
    php artisan key:generate
fi

# Clear caches
print_status "Clearing Laravel caches..."
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

print_success "Setup completed successfully!"
echo ""
echo -e "${GREEN}🎉 Your WiFi QR Generator is now available at:${NC}"
echo -e "${BLUE}   http://wifiqr.local${NC}"
echo -e "${BLUE}   http://www.wifiqr.local${NC}"
echo ""
echo -e "${YELLOW}📝 Next steps:${NC}"
echo "1. Open your browser and visit http://wifiqr.local"
echo "2. Test the WiFi QR generator functionality"
echo "3. If you encounter any issues, check the logs:"
echo "   - Nginx error log: sudo tail -f /var/log/nginx/wifiqr.local_error.log"
echo "   - Nginx access log: sudo tail -f /var/log/nginx/wifiqr.local_access.log"
echo ""
echo -e "${GREEN}✨ Enjoy your local WiFi QR Generator!${NC}"

#!/bin/bash

# Auto setup with sudo password
echo "🚀 Auto setting up wifiqr.net domain..."

# Function to run sudo commands with password
run_sudo() {
    echo "1234" | sudo -S "$@"
}

# Colors
GREEN='\033[0;32m'
BLUE='\033[0;34m'
YELLOW='\033[1;33m'
NC='\033[0m'

echo -e "${BLUE}Step 1: Adding domain to /etc/hosts...${NC}"
if ! grep -q "wifiqr.net" /etc/hosts; then
    echo "127.0.0.1    wifiqr.net www.wifiqr.net" | run_sudo tee -a /etc/hosts
    echo -e "${GREEN}✅ Domain added to /etc/hosts${NC}"
else
    echo -e "${YELLOW}⚠️  Domain already exists in /etc/hosts${NC}"
fi

echo -e "${BLUE}Step 2: Setting up Nginx configuration...${NC}"
run_sudo cp nginx-wifiqr.conf /etc/nginx/sites-available/wifiqr.net

echo -e "${BLUE}Step 3: Enabling Nginx site...${NC}"
run_sudo ln -sf /etc/nginx/sites-available/wifiqr.net /etc/nginx/sites-enabled/

echo -e "${BLUE}Step 4: Checking PHP version and updating config...${NC}"
# Check for PHP versions and update config accordingly
if systemctl is-active --quiet php8.0-fpm; then
    echo "Found PHP 8.0-FPM, updating config..."
    run_sudo sed -i 's/php8.2-fpm/php8.0-fpm/g' /etc/nginx/sites-available/wifiqr.net
elif systemctl is-active --quiet php8.1-fpm; then
    echo "Found PHP 8.1-FPM, updating config..."
    run_sudo sed -i 's/php8.2-fpm/php8.1-fpm/g' /etc/nginx/sites-available/wifiqr.net
elif systemctl is-active --quiet php7.4-fpm; then
    echo "Found PHP 7.4-FPM, updating config..."
    run_sudo sed -i 's/php8.2-fpm/php7.4-fpm/g' /etc/nginx/sites-available/wifiqr.net
fi

echo -e "${BLUE}Step 5: Setting proper permissions...${NC}"
run_sudo chown -R www-data:www-data /var/www/phamhung/wifi_qr/storage
run_sudo chown -R www-data:www-data /var/www/phamhung/wifi_qr/bootstrap/cache
run_sudo chmod -R 775 /var/www/phamhung/wifi_qr/storage
run_sudo chmod -R 775 /var/www/phamhung/wifi_qr/bootstrap/cache

echo -e "${BLUE}Step 6: Testing Nginx configuration...${NC}"
if run_sudo nginx -t; then
    echo -e "${GREEN}✅ Nginx configuration is valid${NC}"
else
    echo -e "${RED}❌ Nginx configuration has errors${NC}"
    exit 1
fi

echo -e "${BLUE}Step 7: Restarting Nginx...${NC}"
run_sudo systemctl restart nginx

if run_sudo systemctl is-active --quiet nginx; then
    echo -e "${GREEN}✅ Nginx restarted successfully${NC}"
else
    echo -e "${RED}❌ Failed to restart Nginx${NC}"
    exit 1
fi

echo -e "${BLUE}Step 8: Laravel setup...${NC}"
cd /var/www/phamhung/wifi_qr

# Generate app key if not exists
if ! grep -q "APP_KEY=base64:" .env 2>/dev/null; then
    echo "Generating Laravel application key..."
    php artisan key:generate
fi

# Clear caches
echo "Clearing Laravel caches..."
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

echo ""
echo -e "${GREEN}🎉 Setup completed successfully!${NC}"
echo ""
echo -e "${GREEN}Your WiFi QR Generator is now available at:${NC}"
echo -e "${BLUE}   http://wifiqr.net${NC}"
echo -e "${BLUE}   http://www.wifiqr.net${NC}"
echo ""
echo -e "${YELLOW}📝 If you encounter any issues, check the logs:${NC}"
echo "   sudo tail -f /var/log/nginx/wifiqr.net_error.log"
echo ""
echo -e "${GREEN}✨ Enjoy your local WiFi QR Generator!${NC}"

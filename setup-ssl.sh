#!/bin/bash

# SSL Certificate Setup for wifiqr.local
# This script creates a self-signed SSL certificate for local development

echo "🔒 Setting up SSL certificate for wifiqr.local..."

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

# Check if OpenSSL is installed
if ! command -v openssl &> /dev/null; then
    print_error "OpenSSL is not installed. Please install it first:"
    echo "sudo apt update && sudo apt install openssl"
    exit 1
fi

# Create SSL directory if it doesn't exist
sudo mkdir -p /etc/ssl/private
sudo mkdir -p /etc/ssl/certs

# Generate private key
print_status "Generating private key..."
sudo openssl genrsa -out /etc/ssl/private/wifiqr.local.key 2048

# Create certificate signing request configuration
print_status "Creating certificate configuration..."
cat > /tmp/wifiqr.local.conf << EOF
[req]
default_bits = 2048
prompt = no
default_md = sha256
distinguished_name = dn
req_extensions = v3_req

[dn]
C=VN
ST=Ho Chi Minh
L=Ho Chi Minh City
O=WiFi QR Generator
OU=Development
CN=wifiqr.local

[v3_req]
basicConstraints = CA:FALSE
keyUsage = nonRepudiation, digitalSignature, keyEncipherment
subjectAltName = @alt_names

[alt_names]
DNS.1 = wifiqr.local
DNS.2 = www.wifiqr.local
DNS.3 = localhost
IP.1 = 127.0.0.1
EOF

# Generate certificate
print_status "Generating SSL certificate..."
sudo openssl req -new -x509 -key /etc/ssl/private/wifiqr.local.key \
    -out /etc/ssl/certs/wifiqr.local.crt \
    -days 365 \
    -config /tmp/wifiqr.local.conf \
    -extensions v3_req

# Set proper permissions
sudo chmod 600 /etc/ssl/private/wifiqr.local.key
sudo chmod 644 /etc/ssl/certs/wifiqr.local.crt

# Clean up
rm /tmp/wifiqr.local.conf

print_success "SSL certificate generated successfully!"

# Update Nginx configuration to enable HTTPS
print_status "Updating Nginx configuration for HTTPS..."

# Create HTTPS-enabled Nginx config
cat > nginx-wifiqr-ssl.conf << 'EOF'
# HTTP to HTTPS redirect
server {
    listen 80;
    server_name wifiqr.local www.wifiqr.local;
    return 301 https://$server_name$request_uri;
}

# HTTPS server
server {
    listen 443 ssl http2;
    server_name wifiqr.local www.wifiqr.local;
    root /var/www/phamhung/wifi_qr/public;
    index index.php index.html index.htm;

    # SSL certificates
    ssl_certificate /etc/ssl/certs/wifiqr.local.crt;
    ssl_certificate_key /etc/ssl/private/wifiqr.local.key;

    # SSL configuration
    ssl_protocols TLSv1.2 TLSv1.3;
    ssl_ciphers ECDHE-RSA-AES256-GCM-SHA512:DHE-RSA-AES256-GCM-SHA512:ECDHE-RSA-AES256-GCM-SHA384:DHE-RSA-AES256-GCM-SHA384;
    ssl_prefer_server_ciphers off;
    ssl_session_cache shared:SSL:10m;
    ssl_session_timeout 10m;

    # Security headers
    add_header X-Frame-Options "SAMEORIGIN" always;
    add_header X-XSS-Protection "1; mode=block" always;
    add_header X-Content-Type-Options "nosniff" always;
    add_header Referrer-Policy "no-referrer-when-downgrade" always;
    add_header Content-Security-Policy "default-src 'self' http: https: data: blob: 'unsafe-inline'" always;
    add_header Strict-Transport-Security "max-age=31536000; includeSubDomains" always;

    # Gzip compression
    gzip on;
    gzip_vary on;
    gzip_min_length 1024;
    gzip_proxied expired no-cache no-store private must-revalidate auth;
    gzip_types text/plain text/css text/xml text/javascript application/x-javascript application/xml+rss application/javascript;

    # Handle Laravel routes
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    # PHP-FPM configuration
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
        fastcgi_hide_header X-Powered-By;
    }

    # Static files caching
    location ~* \.(js|css|png|jpg|jpeg|gif|ico|svg|woff|woff2|ttf|eot)$ {
        expires 1y;
        add_header Cache-Control "public, immutable";
        try_files $uri =404;
    }

    # Deny access to hidden files
    location ~ /\. {
        deny all;
    }

    # Deny access to sensitive files
    location ~ /(?:\.env|\.git|composer\.(json|lock)|package\.json|yarn\.lock|webpack\.mix\.js)$ {
        deny all;
    }

    # Laravel storage and bootstrap cache
    location ~ ^/(storage|bootstrap/cache)/ {
        deny all;
    }

    # Error and access logs
    error_log /var/log/nginx/wifiqr.local_error.log;
    access_log /var/log/nginx/wifiqr.local_access.log;
}
EOF

print_success "HTTPS configuration created!"
echo ""
echo -e "${GREEN}🔒 SSL certificate setup completed!${NC}"
echo ""
echo -e "${YELLOW}📝 To enable HTTPS:${NC}"
echo "1. Copy the HTTPS configuration:"
echo "   sudo cp nginx-wifiqr-ssl.conf /etc/nginx/sites-available/wifiqr.local"
echo ""
echo "2. Test and reload Nginx:"
echo "   sudo nginx -t && sudo systemctl reload nginx"
echo ""
echo "3. Visit: https://wifiqr.local"
echo ""
echo -e "${YELLOW}⚠️  Note:${NC} Your browser will show a security warning because this is a self-signed certificate."
echo "Click 'Advanced' and 'Proceed to wifiqr.local' to continue."

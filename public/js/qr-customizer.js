// QR Code Customizer
class QRCustomizer {
    constructor() {
        this.qrOptions = {
            foregroundColor: '#000000',
            backgroundColor: '#ffffff',
            size: 256,
            margin: 4,
            logo: null,
            logoSize: 0.2,
            cornerRadius: 0
        };

        this.currentTemplate = 'simple';
        this.templates = {
            simple: { name: 'Đơn giản', icon: '📱' },
            cafe: { name: 'Quán cà phê', icon: '☕' },
            hotel: { name: 'Khách sạn', icon: '🏨' },
            office: { name: 'Văn phòng', icon: '🏢' },
            home: { name: 'Nhà riêng', icon: '🏠' }
        };

        // Store current WiFi data
        this.currentWifiString = null;
        this.currentWifiInfo = null;

        this.init();
    }
    
    init() {
        this.setupEventListeners();
        this.renderTemplateSelector();
        // Don't auto-generate QR on init, wait for WiFi data
    }

    // Method to initialize with WiFi data
    initWithWifiData(wifiString, wifiInfo) {
        this.currentWifiString = wifiString;
        this.currentWifiInfo = wifiInfo;

        // Wait a bit for the basic QR to be generated, then convert it
        setTimeout(() => {
            this.updateQRPreview();
        }, 500);
    }
    
    setupEventListeners() {
        // Color pickers
        document.getElementById('qr-fg-color').addEventListener('change', (e) => {
            this.qrOptions.foregroundColor = e.target.value;
            this.updateQRPreview();
        });
        
        document.getElementById('qr-bg-color').addEventListener('change', (e) => {
            this.qrOptions.backgroundColor = e.target.value;
            this.updateQRPreview();
        });
        
        // Size slider
        document.getElementById('qr-size').addEventListener('input', (e) => {
            this.qrOptions.size = parseInt(e.target.value);
            document.getElementById('size-display').textContent = `${this.qrOptions.size}px`;
            this.updateQRPreview();
        });
        
        // Logo upload
        const logoUpload = document.getElementById('logo-upload');
        const logoArea = document.getElementById('logo-upload-area');
        
        logoUpload.addEventListener('change', (e) => this.handleLogoUpload(e));
        
        // Drag and drop for logo
        logoArea.addEventListener('dragover', (e) => {
            e.preventDefault();
            logoArea.classList.add('dragover');
        });
        
        logoArea.addEventListener('dragleave', () => {
            logoArea.classList.remove('dragover');
        });
        
        logoArea.addEventListener('drop', (e) => {
            e.preventDefault();
            logoArea.classList.remove('dragover');
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                this.processLogoFile(files[0]);
            }
        });
        
        logoArea.addEventListener('click', () => logoUpload.click());
        
        // Logo size slider
        document.getElementById('logo-size').addEventListener('input', (e) => {
            this.qrOptions.logoSize = parseFloat(e.target.value);
            document.getElementById('logo-size-display').textContent = `${Math.round(this.qrOptions.logoSize * 100)}%`;
            this.updateQRPreview();
        });
        
        // Corner radius slider
        document.getElementById('corner-radius').addEventListener('input', (e) => {
            this.qrOptions.cornerRadius = parseInt(e.target.value);
            document.getElementById('corner-radius-display').textContent = `${this.qrOptions.cornerRadius}px`;
            this.updateQRPreview();
        });
        
        // Download buttons
        document.getElementById('download-qr-png').addEventListener('click', () => this.downloadQR('png'));
        document.getElementById('download-poster-png').addEventListener('click', () => this.downloadPoster('png'));
        document.getElementById('download-poster-pdf').addEventListener('click', () => this.downloadPoster('pdf'));
    }
    
    handleLogoUpload(event) {
        const file = event.target.files[0];
        if (file) {
            this.processLogoFile(file);
        }
    }
    
    processLogoFile(file) {
        if (!file.type.startsWith('image/')) {
            alert('Vui lòng chọn file hình ảnh!');
            return;
        }
        
        const reader = new FileReader();
        reader.onload = (e) => {
            const img = new Image();
            img.onload = () => {
                this.qrOptions.logo = img;
                this.showLogoPreview(e.target.result);
                this.updateQRPreview();
            };
            img.src = e.target.result;
        };
        reader.readAsDataURL(file);
    }
    
    showLogoPreview(src) {
        const preview = document.getElementById('logo-preview');
        if (preview) {
            preview.src = src;
            preview.style.display = 'block';
        } else {
            const img = document.createElement('img');
            img.id = 'logo-preview';
            img.src = src;
            img.className = 'logo-preview';
            document.getElementById('logo-upload-area').appendChild(img);
        }
        
        // Show remove button
        let removeBtn = document.getElementById('remove-logo');
        if (!removeBtn) {
            removeBtn = document.createElement('button');
            removeBtn.id = 'remove-logo';
            removeBtn.className = 'btn btn-sm btn-outline-danger mt-2';
            removeBtn.innerHTML = '🗑️ Xóa logo';
            removeBtn.onclick = () => this.removeLogo();
            document.getElementById('logo-upload-area').appendChild(removeBtn);
        }
    }
    
    removeLogo() {
        this.qrOptions.logo = null;
        const preview = document.getElementById('logo-preview');
        const removeBtn = document.getElementById('remove-logo');
        if (preview) preview.remove();
        if (removeBtn) removeBtn.remove();
        document.getElementById('logo-upload').value = '';
        this.updateQRPreview();
    }
    
    renderTemplateSelector() {
        const container = document.getElementById('template-selector');
        if (!container) return;

        container.innerHTML = '';

        Object.entries(this.templates).forEach(([key, template]) => {
            const card = document.createElement('div');
            card.className = `template-card ${key === this.currentTemplate ? 'active' : ''}`;
            card.dataset.template = key;
            card.innerHTML = `
                <div class="template-preview">${template.icon}</div>
                <div class="template-name">${template.name}</div>
            `;
            card.addEventListener('click', () => this.selectTemplate(key));
            container.appendChild(card);
        });
    }
    
    selectTemplate(templateKey) {
        this.currentTemplate = templateKey;
        this.renderTemplateSelector();

        // Update poster preview immediately
        setTimeout(() => {
            this.updatePosterPreview();
        }, 100);
    }
    
    async updateQRPreview() {
        const wifiString = this.currentWifiString || this.getWiFiString();
        if (!wifiString) return;

        console.log('Updating QR preview with:', wifiString);

        // Try modern QRCode library first
        if (typeof QRCode !== 'undefined' && QRCode.toCanvas) {
            try {
                const canvas = document.createElement('canvas');
                const ctx = canvas.getContext('2d');

                await QRCode.toCanvas(canvas, wifiString, {
                    width: this.qrOptions.size,
                    margin: this.qrOptions.margin,
                    color: {
                        dark: this.qrOptions.foregroundColor,
                        light: this.qrOptions.backgroundColor
                    }
                });

                // Apply customizations
                if (this.qrOptions.cornerRadius > 0) {
                    this.applyCornerRadius(canvas, this.qrOptions.cornerRadius);
                }

                if (this.qrOptions.logo) {
                    this.addLogoToCanvas(canvas);
                }

                // Update preview
                const preview = document.getElementById('qr-preview');
                preview.innerHTML = '';
                preview.appendChild(canvas);

                console.log('QR canvas created successfully:', canvas.width, 'x', canvas.height);

                // Update poster preview
                this.updatePosterPreview();
                return;

            } catch (error) {
                console.error('Error with modern QRCode library:', error);
            }
        }

        // Fallback: Convert existing QR image to canvas
        this.convertExistingQRToCanvas();
    }

    convertExistingQRToCanvas() {
        console.log('Converting existing QR to canvas...');

        // Find existing QR image - check multiple locations
        const qrImg = document.querySelector('#qr-preview img') ||
                     document.querySelector('#qrcode img') ||
                     document.querySelector('img[src*="qrserver.com"]') ||
                     document.querySelector('img[alt="WiFi QR Code"]');

        if (qrImg && qrImg.complete) {
            console.log('Found QR image, converting to canvas');

            const canvas = document.createElement('canvas');
            canvas.width = this.qrOptions.size;
            canvas.height = this.qrOptions.size;
            const ctx = canvas.getContext('2d');

            // Draw image to canvas
            ctx.drawImage(qrImg, 0, 0, canvas.width, canvas.height);

            // Apply customizations
            if (this.qrOptions.cornerRadius > 0) {
                this.applyCornerRadius(canvas, this.qrOptions.cornerRadius);
            }

            if (this.qrOptions.logo) {
                this.addLogoToCanvas(canvas);
            }

            // Update preview
            const preview = document.getElementById('qr-preview');
            preview.innerHTML = '';
            preview.appendChild(canvas);

            console.log('QR image converted to canvas successfully');

            // Update poster preview
            this.updatePosterPreview();
        } else {
            console.warn('No QR image found to convert');
        }
    }
    
    applyCornerRadius(canvas, radius) {
        if (radius <= 0) return;

        const ctx = canvas.getContext('2d');
        const imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);

        // Create a new canvas with rounded corners
        const roundedCanvas = document.createElement('canvas');
        roundedCanvas.width = canvas.width;
        roundedCanvas.height = canvas.height;
        const roundedCtx = roundedCanvas.getContext('2d');

        // Draw rounded rectangle path
        roundedCtx.beginPath();
        this.drawRoundedRect(roundedCtx, 0, 0, canvas.width, canvas.height, radius);
        roundedCtx.clip();

        // Draw the original image
        roundedCtx.putImageData(imageData, 0, 0);

        // Replace original canvas content
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        ctx.drawImage(roundedCanvas, 0, 0);
    }

    drawRoundedRect(ctx, x, y, width, height, radius) {
        ctx.moveTo(x + radius, y);
        ctx.lineTo(x + width - radius, y);
        ctx.quadraticCurveTo(x + width, y, x + width, y + radius);
        ctx.lineTo(x + width, y + height - radius);
        ctx.quadraticCurveTo(x + width, y + height, x + width - radius, y + height);
        ctx.lineTo(x + radius, y + height);
        ctx.quadraticCurveTo(x, y + height, x, y + height - radius);
        ctx.lineTo(x, y + radius);
        ctx.quadraticCurveTo(x, y, x + radius, y);
        ctx.closePath();
    }
    
    addLogoToCanvas(canvas) {
        if (!this.qrOptions.logo) return;

        const ctx = canvas.getContext('2d');
        const logo = this.qrOptions.logo;

        const logoSize = canvas.width * this.qrOptions.logoSize;
        const x = (canvas.width - logoSize) / 2;
        const y = (canvas.height - logoSize) / 2;

        // Draw white background for logo with rounded corners
        ctx.fillStyle = '#ffffff';
        ctx.beginPath();
        this.drawRoundedRect(ctx, x - 8, y - 8, logoSize + 16, logoSize + 16, 8);
        ctx.fill();

        // Add subtle shadow
        ctx.shadowColor = 'rgba(0,0,0,0.2)';
        ctx.shadowBlur = 4;
        ctx.shadowOffsetX = 2;
        ctx.shadowOffsetY = 2;

        // Draw logo
        ctx.drawImage(logo, x, y, logoSize, logoSize);

        // Reset shadow
        ctx.shadowColor = 'transparent';
        ctx.shadowBlur = 0;
        ctx.shadowOffsetX = 0;
        ctx.shadowOffsetY = 0;
    }
    
    getWiFiString() {
        const ssid = document.getElementById('ssid').value;
        const password = document.getElementById('password').value;
        const encryption = document.getElementById('encryption').value;
        
        if (!ssid) return null;
        
        return `WIFI:T:${encryption};S:${ssid};P:${password};;`;
    }
    
    async updatePosterPreview() {
        console.log('Updating poster preview, template:', this.currentTemplate);

        if (!window.PosterGenerator) {
            console.error('PosterGenerator not available');
            return;
        }

        // Use global poster generator instance or create new one
        if (!window.globalPosterGenerator) {
            window.globalPosterGenerator = new window.PosterGenerator();
        }

        const posterGenerator = window.globalPosterGenerator;

        // Try multiple ways to get QR canvas
        let qrCanvas = document.querySelector('#qr-preview canvas');
        if (!qrCanvas) {
            // Try to get from QR container and convert img to canvas
            const qrImg = document.querySelector('#qr-preview img') ||
                         document.querySelector('#qrcode img') ||
                         document.querySelector('img[src*="qrserver.com"]') ||
                         document.querySelector('img[alt="WiFi QR Code"]');
            console.log('Trying to get QR from img tag:', !!qrImg, 'Image src:', qrImg?.src?.substring(0, 50));

            if (qrImg && qrImg.complete) {
                // Convert img to canvas
                qrCanvas = document.createElement('canvas');
                qrCanvas.width = 256;
                qrCanvas.height = 256;
                const ctx = qrCanvas.getContext('2d');
                ctx.drawImage(qrImg, 0, 0, 256, 256);
                console.log('Converted QR img to canvas for poster');
            }
        }

        const wifiInfo = this.currentWifiInfo || {
            ssid: document.getElementById('ssid').value,
            encryption: document.getElementById('encryption').value
        };

        console.log('QR Canvas found:', !!qrCanvas, 'Canvas details:', qrCanvas?.width, 'x', qrCanvas?.height);
        console.log('WiFi Info:', wifiInfo);

        if (wifiInfo.ssid) {
            try {
                // If we have QR canvas, use it; otherwise poster will show placeholder
                await posterGenerator.generatePoster(this.currentTemplate, qrCanvas, wifiInfo);
                console.log('Poster preview updated successfully');
            } catch (error) {
                console.error('Error updating poster preview:', error);
            }
        } else {
            console.warn('Missing WiFi info for poster generation');
        }
    }
    
    async downloadQR(format) {
        const canvas = document.querySelector('#qr-preview canvas');
        if (!canvas) {
            alert('Vui lòng tạo mã QR trước!');
            return;
        }
        
        const ssid = document.getElementById('ssid').value || 'wifi-qr';
        
        if (format === 'png') {
            const link = document.createElement('a');
            link.download = `wifi-qr-${ssid}.png`;
            link.href = canvas.toDataURL();
            link.click();
        }
    }
    
    async downloadPoster(format) {
        console.log('Downloading poster in format:', format);

        if (!window.globalPosterGenerator) {
            alert('Poster chưa được tạo! Vui lòng chọn template trước.');
            return;
        }

        const posterGenerator = window.globalPosterGenerator;
        const ssid = document.getElementById('ssid').value || 'wifi';

        try {
            await posterGenerator.downloadPoster(format, `wifi-poster-${ssid}`);
            console.log('Poster downloaded successfully');
        } catch (error) {
            console.error('Error downloading poster:', error);
            alert('Lỗi khi tải poster: ' + error.message);
        }
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    // Only initialize when needed, not immediately
    window.QRCustomizer = QRCustomizer;

    // Create instance when first QR is generated
    window.initializeQRCustomizer = function() {
        if (!window.qrCustomizer) {
            window.qrCustomizer = new QRCustomizer();
        }
        return window.qrCustomizer;
    };
});

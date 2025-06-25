// Poster Generator for WiFi QR Codes
class PosterGenerator {
    constructor() {
        this.canvas = null;
        this.ctx = null;
        this.templates = {
            simple: {
                name: 'Đơn giản',
                background: 'linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%)',
                primaryColor: '#1e293b',
                secondaryColor: '#64748b',
                layout: 'center'
            },
            cafe: {
                name: 'Quán cà phê',
                background: 'linear-gradient(135deg, #92400e 0%, #d97706 100%)',
                primaryColor: '#ffffff',
                secondaryColor: '#fef3c7',
                layout: 'cafe',
                decorations: ['☕', '🥐', '☕']
            },
            hotel: {
                name: 'Khách sạn',
                background: 'linear-gradient(135deg, #1e40af 0%, #3b82f6 100%)',
                primaryColor: '#ffffff',
                secondaryColor: '#dbeafe',
                layout: 'elegant',
                decorations: ['🏨', '🛎️', '🗝️']
            },
            office: {
                name: 'Văn phòng',
                background: 'linear-gradient(135deg, #4338ca 0%, #6366f1 100%)',
                primaryColor: '#ffffff',
                secondaryColor: '#e0e7ff',
                layout: 'professional',
                decorations: ['💼', '📊', '💻']
            },
            home: {
                name: 'Nhà riêng',
                background: 'linear-gradient(135deg, #ec4899 0%, #f472b6 100%)',
                primaryColor: '#ffffff',
                secondaryColor: '#fce7f3',
                layout: 'cozy',
                decorations: ['🏠', '🌸', '💝']
            }
        };
        
        this.posterSizes = {
            a4: { width: 600, height: 848, name: 'A4 (210×297mm)' },
            a5: { width: 420, height: 595, name: 'A5 (148×210mm)' },
            card: { width: 300, height: 420, name: 'Card (84×119mm)' },
            square: { width: 500, height: 500, name: 'Vuông (200×200mm)' }
        };
        
        this.currentSize = 'a5';
        this.init();
    }
    
    init() {
        this.createCanvas();
        this.setupSizeSelector();
    }
    
    createCanvas() {
        this.canvas = document.createElement('canvas');
        this.ctx = this.canvas.getContext('2d');

        // Set initial size
        const size = this.posterSizes[this.currentSize];
        this.canvas.width = size.width;
        this.canvas.height = size.height;

        // Style canvas for preview
        this.canvas.style.maxWidth = '100%';
        this.canvas.style.height = 'auto';
        this.canvas.style.border = '2px solid #007bff';
        this.canvas.style.borderRadius = '8px';
        this.canvas.style.boxShadow = '0 4px 8px rgba(0,0,0,0.1)';
        this.canvas.style.display = 'block';
        this.canvas.style.margin = '10px auto';

        // Add to preview container
        const container = document.getElementById('poster-preview');
        if (container) {
            container.innerHTML = '<p style="text-align: center; color: #666;">Đang tạo poster...</p>';
            setTimeout(() => {
                container.innerHTML = '';
                container.appendChild(this.canvas);
                console.log('Canvas added to container:', this.canvas.width, 'x', this.canvas.height);

                // Draw initial background to test
                this.ctx.fillStyle = '#f0f0f0';
                this.ctx.fillRect(0, 0, this.canvas.width, this.canvas.height);
                this.ctx.fillStyle = '#007bff';
                this.ctx.font = 'bold 20px Arial';
                this.ctx.textAlign = 'center';
                this.ctx.fillText('Poster Canvas Ready', this.canvas.width/2, this.canvas.height/2);
            }, 100);
        } else {
            console.error('Poster preview container not found');
        }

        console.log('Canvas created:', this.canvas.width, 'x', this.canvas.height);
    }
    
    setupSizeSelector() {
        const selector = document.getElementById('poster-size-selector');
        if (!selector) return;
        
        selector.innerHTML = '';
        Object.entries(this.posterSizes).forEach(([key, size]) => {
            const option = document.createElement('option');
            option.value = key;
            option.textContent = size.name;
            option.selected = key === this.currentSize;
            selector.appendChild(option);
        });
        
        selector.addEventListener('change', (e) => {
            this.currentSize = e.target.value;
            this.createCanvas();
            this.generatePoster();
        });
    }
    
    async generatePoster(template = 'simple', qrCanvas = null, wifiInfo = {}) {
        console.log('Generating poster:', template, 'QR Canvas:', qrCanvas, 'WiFi Info:', wifiInfo);

        if (!this.canvas || !this.ctx) {
            console.error('Canvas not initialized');
            return;
        }

        const templateConfig = this.templates[template];
        if (!templateConfig) {
            console.error('Template not found:', template);
            return;
        }

        const size = this.posterSizes[this.currentSize];
        console.log('Canvas size:', this.canvas.width, 'x', this.canvas.height);

        // Clear canvas
        this.ctx.clearRect(0, 0, this.canvas.width, this.canvas.height);

        // Draw background
        await this.drawBackground(templateConfig);
        console.log('Background drawn');

        // Draw content based on template
        switch (templateConfig.layout) {
            case 'cafe':
                await this.drawCafeLayout(templateConfig, qrCanvas, wifiInfo);
                break;
            case 'hotel':
                await this.drawHotelLayout(templateConfig, qrCanvas, wifiInfo);
                break;
            case 'professional':
                await this.drawProfessionalLayout(templateConfig, qrCanvas, wifiInfo);
                break;
            case 'cozy':
                await this.drawCozyLayout(templateConfig, qrCanvas, wifiInfo);
                break;
            default:
                await this.drawSimpleLayout(templateConfig, qrCanvas, wifiInfo);
        }
        console.log('Layout drawn');

        // Add decorative elements
        if (templateConfig.decorations) {
            this.drawDecorations(templateConfig.decorations);
            console.log('Decorations drawn');
        }

        console.log('Poster generation complete');
        return this.canvas;
    }
    
    async drawBackground(template) {
        if (template.background.includes('gradient')) {
            // Parse gradient colors
            const colors = template.background.match(/#[0-9a-fA-F]{6}/g) || ['#ffffff', '#f0f0f0'];
            const gradient = this.ctx.createLinearGradient(0, 0, this.canvas.width, this.canvas.height);
            gradient.addColorStop(0, colors[0]);
            gradient.addColorStop(1, colors[1] || colors[0]);
            this.ctx.fillStyle = gradient;
        } else {
            this.ctx.fillStyle = template.background;
        }

        this.ctx.fillRect(0, 0, this.canvas.width, this.canvas.height);
    }
    
    async drawSimpleLayout(template, qrCanvas, wifiInfo) {
        console.log('Drawing simple layout...');
        const centerX = this.canvas.width / 2;
        const centerY = this.canvas.height / 2;

        // Modern title with icon
        this.drawText('📶 WiFi miễn phí', centerX, this.canvas.height * 0.15, {
            fontSize: Math.min(this.canvas.width / 8, 32),
            color: template.primaryColor,
            align: 'center',
            weight: 'bold'
        });

        // Subtitle
        this.drawText('Kết nối nhanh chóng', centerX, this.canvas.height * 0.25, {
            fontSize: Math.min(this.canvas.width / 12, 24),
            color: template.secondaryColor,
            align: 'center',
            style: 'italic'
        });

        // QR Code with modern styling
        if (qrCanvas) {
            const qrSize = Math.min(this.canvas.width * 0.5, this.canvas.height * 0.4, 200);
            const qrX = centerX - qrSize/2;
            const qrY = centerY - qrSize/2;

            console.log('Drawing QR code from canvas, size:', qrSize, 'QR canvas size:', qrCanvas.width, 'x', qrCanvas.height);

            // Add modern frame with shadow
            this.ctx.fillStyle = 'rgba(0,0,0,0.1)';
            this.ctx.fillRect(qrX - 8, qrY - 4, qrSize + 16, qrSize + 8);

            this.ctx.fillStyle = '#ffffff';
            this.ctx.fillRect(qrX - 12, qrY - 12, qrSize + 24, qrSize + 24);

            this.ctx.strokeStyle = template.primaryColor;
            this.ctx.lineWidth = 2;
            this.ctx.strokeRect(qrX - 8, qrY - 8, qrSize + 16, qrSize + 16);

            // Draw the QR code
            this.ctx.drawImage(qrCanvas, qrX, qrY, qrSize, qrSize);
            console.log('QR code drawn successfully');
        } else {
            console.log('No QR canvas provided, drawing placeholder');
            // Draw QR placeholder
            const qrSize = Math.min(this.canvas.width * 0.5, this.canvas.height * 0.4, 200);
            const qrX = centerX - qrSize/2;
            const qrY = centerY - qrSize/2;

            this.ctx.fillStyle = template.primaryColor;
            this.ctx.fillRect(qrX, qrY, qrSize, qrSize);
            this.ctx.fillStyle = '#ffffff';
            this.ctx.fillRect(qrX + 15, qrY + 15, qrSize - 30, qrSize - 30);
            this.drawText('QR', centerX, centerY, {
                fontSize: 24,
                color: template.primaryColor,
                align: 'center'
            });
        }

        // Instructions
        this.drawText('Quét mã để kết nối', centerX, this.canvas.height * 0.8, {
            fontSize: Math.min(this.canvas.width / 15, 20),
            color: template.primaryColor,
            align: 'center',
            weight: 'bold'
        });

        // WiFi name
        if (wifiInfo.ssid) {
            this.drawText(`📡 ${wifiInfo.ssid}`, centerX, this.canvas.height * 0.87, {
                fontSize: Math.min(this.canvas.width / 20, 16),
                color: template.secondaryColor,
                align: 'center'
            });
        }

        console.log('Simple layout drawn');
    }
    
    async drawCafeLayout(template, qrCanvas, wifiInfo) {
        const centerX = this.canvas.width / 2;
        const centerY = this.canvas.height / 2;

        // Decorative header
        this.drawText('☕ WiFi Quán Cà Phê ☕', centerX, this.canvas.height * 0.15, {
            fontSize: Math.min(this.canvas.width / 8, 32),
            color: template.primaryColor,
            align: 'center',
            weight: 'bold'
        });

        // Welcome message
        this.drawText('Chào mừng bạn đến với quán!', centerX, this.canvas.height * 0.25, {
            fontSize: Math.min(this.canvas.width / 12, 24),
            color: template.secondaryColor,
            align: 'center',
            style: 'italic'
        });

        // QR Code with decorative frame
        if (qrCanvas) {
            const qrSize = Math.min(this.canvas.width * 0.5, this.canvas.height * 0.4, 200);
            const qrX = centerX - qrSize/2;
            const qrY = centerY - qrSize/2;

            // Draw decorative frame with coffee theme
            this.ctx.fillStyle = template.primaryColor;
            this.ctx.fillRect(qrX - 15, qrY - 15, qrSize + 30, qrSize + 30);

            this.ctx.fillStyle = '#ffffff';
            this.ctx.fillRect(qrX - 8, qrY - 8, qrSize + 16, qrSize + 16);

            this.ctx.drawImage(qrCanvas, qrX, qrY, qrSize, qrSize);
        } else {
            // Draw QR placeholder with frame
            const qrSize = Math.min(this.canvas.width * 0.5, this.canvas.height * 0.4, 200);
            const qrX = centerX - qrSize/2;
            const qrY = centerY - qrSize/2;

            this.ctx.fillStyle = template.primaryColor;
            this.ctx.fillRect(qrX - 15, qrY - 15, qrSize + 30, qrSize + 30);
            this.ctx.fillStyle = '#ffffff';
            this.ctx.fillRect(qrX - 8, qrY - 8, qrSize + 16, qrSize + 16);
            this.ctx.fillStyle = template.primaryColor;
            this.ctx.fillRect(qrX + 20, qrY + 20, qrSize - 40, qrSize - 40);

            this.drawText('QR', centerX, centerY, {
                fontSize: 24,
                color: '#ffffff',
                align: 'center'
            });
        }

        // Instructions
        this.drawText('Quét mã QR để kết nối WiFi miễn phí', centerX, this.canvas.height * 0.8, {
            fontSize: Math.min(this.canvas.width / 15, 20),
            color: template.primaryColor,
            align: 'center',
            weight: 'bold'
        });

        // WiFi details
        if (wifiInfo.ssid) {
            this.drawText(`📶 ${wifiInfo.ssid}`, centerX, this.canvas.height * 0.87, {
                fontSize: Math.min(this.canvas.width / 20, 16),
                color: template.secondaryColor,
                align: 'center'
            });
        }

        // Footer message
        this.drawText('Cảm ơn bạn đã ghé thăm! ☕', centerX, this.canvas.height * 0.94, {
            fontSize: Math.min(this.canvas.width / 25, 14),
            color: template.secondaryColor,
            align: 'center',
            style: 'italic'
        });
    }
    
    async drawHotelLayout(template, qrCanvas, wifiInfo) {
        const centerX = this.canvas.width / 2;
        const centerY = this.canvas.height / 2;

        // Elegant header
        this.drawText('🏨 KHÁCH SẠN', centerX, this.canvas.height * 0.15, {
            fontSize: Math.min(this.canvas.width / 8, 32),
            color: template.primaryColor,
            align: 'center',
            weight: 'bold',
            letterSpacing: 3
        });

        this.drawText('WiFi Miễn Phí', centerX, this.canvas.height * 0.25, {
            fontSize: Math.min(this.canvas.width / 12, 24),
            color: template.secondaryColor,
            align: 'center',
            style: 'italic'
        });

        // Decorative line
        this.ctx.strokeStyle = template.primaryColor;
        this.ctx.lineWidth = 2;
        this.ctx.beginPath();
        this.ctx.moveTo(centerX - this.canvas.width * 0.3, this.canvas.height * 0.32);
        this.ctx.lineTo(centerX + this.canvas.width * 0.3, this.canvas.height * 0.32);
        this.ctx.stroke();

        // QR Code with elegant frame
        if (qrCanvas) {
            const qrSize = Math.min(this.canvas.width * 0.5, this.canvas.height * 0.4, 200);
            const qrX = centerX - qrSize/2;
            const qrY = centerY - qrSize/2;

            // Elegant border
            this.ctx.strokeStyle = template.primaryColor;
            this.ctx.lineWidth = 4;
            this.ctx.strokeRect(qrX - 20, qrY - 20, qrSize + 40, qrSize + 40);

            this.ctx.fillStyle = '#ffffff';
            this.ctx.fillRect(qrX - 15, qrY - 15, qrSize + 30, qrSize + 30);

            this.ctx.drawImage(qrCanvas, qrX, qrY, qrSize, qrSize);
        }

        // Instructions
        this.drawText('Quét mã QR để kết nối WiFi miễn phí', centerX, this.canvas.height * 0.8, {
            fontSize: Math.min(this.canvas.width / 15, 20),
            color: template.primaryColor,
            align: 'center',
            weight: 'bold'
        });

        if (wifiInfo.ssid) {
            this.drawText(`🌐 ${wifiInfo.ssid}`, centerX, this.canvas.height * 0.87, {
                fontSize: Math.min(this.canvas.width / 20, 16),
                color: template.secondaryColor,
                align: 'center'
            });
        }

        // Footer
        this.drawText('Chúc quý khách có kỳ nghỉ tuyệt vời', centerX, this.canvas.height * 0.94, {
            fontSize: Math.min(this.canvas.width / 25, 14),
            color: template.secondaryColor,
            align: 'center',
            style: 'italic'
        });
    }

    async drawProfessionalLayout(templateConfig, qrCanvas, wifiInfo) {
        const centerX = this.canvas.width / 2;
        const centerY = this.canvas.height / 2;

        // Professional header - responsive sizing
        this.drawText('🏢 VĂN PHÒNG', centerX, this.canvas.height * 0.15, {
            fontSize: Math.min(this.canvas.width / 8, 32),
            color: templateConfig.primaryColor,
            align: 'center',
            weight: 'bold',
            letterSpacing: 2
        });

        // Subtitle
        this.drawText('WiFi Doanh Nghiệp', centerX, this.canvas.height * 0.25, {
            fontSize: Math.min(this.canvas.width / 12, 24),
            color: templateConfig.secondaryColor,
            align: 'center',
            style: 'italic'
        });

        // QR Code with professional frame - fixed positioning
        if (qrCanvas) {
            const qrSize = Math.min(this.canvas.width * 0.5, this.canvas.height * 0.4, 200);
            const qrX = centerX - qrSize/2;
            const qrY = centerY - qrSize/2;

            // Professional border with shadow effect
            this.ctx.fillStyle = 'rgba(0,0,0,0.1)';
            this.ctx.fillRect(qrX - 12, qrY - 8, qrSize + 24, qrSize + 16);

            this.ctx.fillStyle = templateConfig.primaryColor;
            this.ctx.fillRect(qrX - 15, qrY - 15, qrSize + 30, qrSize + 30);

            this.ctx.fillStyle = '#ffffff';
            this.ctx.fillRect(qrX - 10, qrY - 10, qrSize + 20, qrSize + 20);

            this.ctx.drawImage(qrCanvas, qrX, qrY, qrSize, qrSize);
        }

        // Instructions
        this.drawText('Quét mã QR để kết nối', centerX, this.canvas.height * 0.8, {
            fontSize: Math.min(this.canvas.width / 15, 20),
            color: templateConfig.primaryColor,
            align: 'center',
            weight: 'bold'
        });

        if (wifiInfo.ssid) {
            this.drawText(`Mạng: ${wifiInfo.ssid}`, centerX, this.canvas.height * 0.87, {
                fontSize: Math.min(this.canvas.width / 20, 16),
                color: templateConfig.secondaryColor,
                align: 'center'
            });
        }

        // Footer
        this.drawText('Chỉ dành cho nhân viên', centerX, this.canvas.height * 0.94, {
            fontSize: Math.min(this.canvas.width / 25, 14),
            color: templateConfig.secondaryColor,
            align: 'center',
            style: 'italic'
        });
    }

    async drawCozyLayout(templateConfig, qrCanvas, wifiInfo) {
        const centerX = this.canvas.width / 2;
        const centerY = this.canvas.height / 2;

        // Cozy header - responsive sizing
        this.drawText('🏠 Chào mừng về nhà! 🏠', centerX, this.canvas.height * 0.15, {
            fontSize: Math.min(this.canvas.width / 8, 32),
            color: templateConfig.primaryColor,
            align: 'center',
            weight: 'bold'
        });

        // Welcome message
        this.drawText('WiFi gia đình', centerX, this.canvas.height * 0.25, {
            fontSize: Math.min(this.canvas.width / 12, 24),
            color: templateConfig.secondaryColor,
            align: 'center',
            style: 'italic'
        });

        // QR Code with decorative elements - fixed positioning
        if (qrCanvas) {
            const qrSize = Math.min(this.canvas.width * 0.5, this.canvas.height * 0.4, 200);
            const qrX = centerX - qrSize/2;
            const qrY = centerY - qrSize/2;

            // Decorative background with rounded corners
            this.ctx.fillStyle = 'rgba(255,255,255,0.95)';
            this.ctx.fillRect(qrX - 20, qrY - 20, qrSize + 40, qrSize + 40);

            // Add soft border
            this.ctx.strokeStyle = templateConfig.primaryColor;
            this.ctx.lineWidth = 3;
            this.ctx.strokeRect(qrX - 15, qrY - 15, qrSize + 30, qrSize + 30);

            this.ctx.drawImage(qrCanvas, qrX, qrY, qrSize, qrSize);
        }

        // Instructions
        this.drawText('Quét mã để kết nối WiFi nhà', centerX, this.canvas.height * 0.8, {
            fontSize: Math.min(this.canvas.width / 15, 20),
            color: templateConfig.primaryColor,
            align: 'center',
            weight: 'bold'
        });

        if (wifiInfo.ssid) {
            this.drawText(`🌐 ${wifiInfo.ssid}`, centerX, this.canvas.height * 0.87, {
                fontSize: Math.min(this.canvas.width / 20, 16),
                color: templateConfig.secondaryColor,
                align: 'center'
            });
        }

        // Footer
        this.drawText('Cảm ơn bạn đã ghé thăm! 💕', centerX, this.canvas.height * 0.94, {
            fontSize: Math.min(this.canvas.width / 25, 14),
            color: templateConfig.secondaryColor,
            align: 'center',
            style: 'italic'
        });
    }
    
    drawText(text, x, y, options = {}) {
        const {
            fontSize = 40,
            color = '#000000',
            align = 'left',
            weight = 'normal',
            style = 'normal',
            letterSpacing = 0
        } = options;
        
        this.ctx.font = `${style} ${weight} ${fontSize}px Arial, sans-serif`;
        this.ctx.fillStyle = color;
        this.ctx.textAlign = align;
        this.ctx.textBaseline = 'middle';
        
        if (letterSpacing > 0) {
            // Manual letter spacing
            const chars = text.split('');
            let currentX = x - (this.ctx.measureText(text).width / 2);
            chars.forEach(char => {
                this.ctx.fillText(char, currentX, y);
                currentX += this.ctx.measureText(char).width + letterSpacing;
            });
        } else {
            this.ctx.fillText(text, x, y);
        }
    }
    
    drawDecorations(decorations) {
        // Add decorative elements around the poster
        const positions = [
            { x: 200, y: 200 },
            { x: this.canvas.width - 200, y: 200 },
            { x: 200, y: this.canvas.height - 200 },
            { x: this.canvas.width - 200, y: this.canvas.height - 200 }
        ];
        
        decorations.forEach((decoration, index) => {
            if (positions[index]) {
                this.drawText(decoration, positions[index].x, positions[index].y, {
                    fontSize: 80,
                    align: 'center'
                });
            }
        });
    }
    
    async downloadPoster(format = 'png', filename = 'wifi-poster') {
        if (!this.canvas) return;
        
        if (format === 'png') {
            const link = document.createElement('a');
            link.download = `${filename}.png`;
            link.href = this.canvas.toDataURL('image/png', 1.0);
            link.click();
        } else if (format === 'pdf') {
            // Use jsPDF to create PDF
            const { jsPDF } = window.jspdf;
            const size = this.posterSizes[this.currentSize];
            
            // Convert pixels to mm (assuming 300 DPI)
            const mmWidth = (size.width * 25.4) / 300;
            const mmHeight = (size.height * 25.4) / 300;
            
            const pdf = new jsPDF({
                orientation: mmWidth > mmHeight ? 'landscape' : 'portrait',
                unit: 'mm',
                format: [mmWidth, mmHeight]
            });
            
            const imgData = this.canvas.toDataURL('image/png', 1.0);
            pdf.addImage(imgData, 'PNG', 0, 0, mmWidth, mmHeight);
            pdf.save(`${filename}.pdf`);
        }
    }
}

// Make it globally available
window.PosterGenerator = PosterGenerator;

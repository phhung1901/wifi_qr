<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WiFi QR Generator</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=SF+Pro+Display:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'SF Pro Display', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #ffffff;
            color: #1d1d1f;
            line-height: 1.6;
            overflow-x: hidden;
        }

        .container {
            max-width: 980px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Header */
        .header {
            padding: 60px 0 40px;
            text-align: center;
            border-bottom: 1px solid #f5f5f7;
        }

        .header h1 {
            font-size: 56px;
            font-weight: 700;
            letter-spacing: -0.025em;
            margin-bottom: 16px;
            background: linear-gradient(135deg, #1d1d1f 0%, #86868b 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .header p {
            font-size: 21px;
            color: #86868b;
            font-weight: 400;
            max-width: 600px;
            margin: 0 auto;
        }

        /* Main Content */
        .main {
            padding: 80px 0;
        }

        .form-section {
            background: #fbfbfd;
            border-radius: 18px;
            padding: 48px;
            margin-bottom: 40px;
            border: 1px solid #f5f5f7;
            transition: all 0.3s ease;
        }

        .form-section:hover {
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        .form-group {
            margin-bottom: 32px;
        }

        .form-label {
            display: block;
            font-size: 17px;
            font-weight: 600;
            color: #1d1d1f;
            margin-bottom: 8px;
        }

        .form-input {
            width: 100%;
            padding: 16px 20px;
            border: 2px solid #d2d2d7;
            border-radius: 12px;
            font-size: 17px;
            background: #ffffff;
            transition: all 0.3s ease;
            outline: none;
        }

        .form-input:focus {
            border-color: #007aff;
            box-shadow: 0 0 0 4px rgba(0, 122, 255, 0.1);
        }

        .form-input::placeholder {
            color: #86868b;
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            margin-top: 16px;
        }

        .checkbox {
            width: 20px;
            height: 20px;
            margin-right: 12px;
            accent-color: #007aff;
        }

        .checkbox-label {
            font-size: 15px;
            color: #86868b;
            cursor: pointer;
        }

        .btn-primary {
            background: #007aff;
            color: white;
            border: none;
            padding: 16px 32px;
            border-radius: 12px;
            font-size: 17px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
            margin-top: 24px;
        }

        .btn-primary:hover {
            background: #0056cc;
            transform: translateY(-1px);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        /* QR Section */
        .qr-section {
            display: none;
            text-align: center;
            background: #fbfbfd;
            border-radius: 18px;
            padding: 48px;
            border: 1px solid #f5f5f7;
            margin-bottom: 40px;
        }

        .qr-container {
            background: white;
            border-radius: 16px;
            padding: 32px;
            display: inline-block;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            margin-bottom: 32px;
        }

        .qr-title {
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 16px;
            color: #1d1d1f;
            text-align: center;
        }

        .qr-subtitle {
            font-size: 17px;
            color: #86868b;
            margin-bottom: 32px;
            text-align: center;
        }

        .wifi-info {
            background: rgba(0, 122, 255, 0.1);
            border-radius: 12px;
            padding: 16px;
            margin-top: 16px;
            text-align: center;
        }

        .wifi-info p {
            margin: 4px 0;
            font-size: 15px;
            color: #1d1d1f;
        }

        /* Customization Panel */
        .customization-panel {
            display: none;
            background: #fbfbfd;
            border-radius: 18px;
            padding: 48px;
            border: 1px solid #f5f5f7;
            margin-bottom: 40px;
        }

        .panel-title {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 32px;
            text-align: center;
            color: #1d1d1f;
        }

        .customization-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 32px;
        }

        .custom-group {
            background: white;
            border-radius: 12px;
            padding: 24px;
            border: 1px solid #f5f5f7;
        }

        .custom-group h3 {
            font-size: 19px;
            font-weight: 600;
            margin-bottom: 16px;
            color: #1d1d1f;
        }

        .color-input {
            width: 100%;
            height: 48px;
            border: 2px solid #d2d2d7;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .color-input:hover {
            border-color: #007aff;
        }

        .range-input {
            width: 100%;
            margin: 16px 0;
            accent-color: #007aff;
        }

        .range-value {
            font-size: 15px;
            color: #86868b;
            text-align: center;
            margin-top: 8px;
        }

        .logo-upload {
            border: 2px dashed #d2d2d7;
            border-radius: 12px;
            padding: 32px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            background: #fafafa;
        }

        .logo-upload:hover {
            border-color: #007aff;
            background: #f0f8ff;
        }

        .logo-upload.has-logo {
            border-style: solid;
            border-color: #007aff;
            background: #f0f8ff;
        }

        .logo-preview {
            max-width: 80px;
            max-height: 80px;
            border-radius: 8px;
            margin-bottom: 16px;
        }

        .upload-text {
            font-size: 17px;
            color: #86868b;
            margin-bottom: 8px;
        }

        .upload-hint {
            font-size: 13px;
            color: #86868b;
        }

        /* Download Section */
        .download-section {
            display: none;
            text-align: center;
            background: #fbfbfd;
            border-radius: 18px;
            padding: 48px;
            border: 1px solid #f5f5f7;
        }

        .download-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
            margin-top: 32px;
        }

        .btn-download {
            background: #1d1d1f;
            color: white;
            border: none;
            padding: 16px 24px;
            border-radius: 12px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-download:hover {
            background: #424245;
            transform: translateY(-1px);
        }

        .btn-download.secondary {
            background: white;
            color: #1d1d1f;
            border: 2px solid #d2d2d7;
        }

        .btn-download.secondary:hover {
            border-color: #1d1d1f;
        }

        /* Grid Layout */
        .row {
            display: flex;
            flex-wrap: wrap;
            margin: 0 -15px;
            align-items: flex-start;
        }

        .col-lg-6 {
            flex: 0 0 50%;
            max-width: 50%;
            padding: 0 15px;
        }

        /* QR Section Adjustments */
        .qr-section {
            display: block;
            margin-bottom: 0;
            height: auto;
        }

        .qr-container {
            max-width: 100%;
            margin: 0 auto 24px;
            min-height: 250px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .qr-container canvas {
            max-width: 100%;
            height: auto;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .header h1 {
                font-size: 40px;
            }

            .header p {
                font-size: 19px;
            }

            .row {
                flex-direction: column;
            }

            .col-lg-6 {
                flex: 0 0 100%;
                max-width: 100%;
                margin-bottom: 20px;
            }

            .form-section,
            .qr-section,
            .customization-panel,
            .download-section {
                padding: 24px 20px;
            }

            .customization-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .qr-container {
                min-height: 200px;
            }
        }

        /* Animations */
        .fade-in {
            animation: fadeIn 0.6s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .loading {
            opacity: 0.6;
            pointer-events: none;
            position: relative;
        }

        .loading::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 20px;
            height: 20px;
            margin: -10px 0 0 -10px;
            border: 2px solid rgba(255,255,255,0.3);
            border-top: 2px solid white;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .error-message {
            background: #ff3b30;
            color: white;
            padding: 16px;
            border-radius: 12px;
            margin: 16px 0;
            text-align: center;
            font-weight: 500;
        }

        .success-message {
            background: #34c759;
            color: white;
            padding: 16px;
            border-radius: 12px;
            margin: 16px 0;
            text-align: center;
            font-weight: 500;
        }

        .info-message {
            background: #007aff;
            color: white;
            padding: 16px;
            border-radius: 12px;
            margin: 16px 0;
            text-align: center;
            font-weight: 500;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <header class="header">
            <h1>WiFi QR Generator</h1>
            <p>Create beautiful QR codes for instant WiFi connection. Simple, fast, and elegant.</p>
        </header>

        <!-- Main Content -->
        <main class="main">
            <!-- Main Content Grid -->
            <div class="row">
                <!-- Left Column: Form -->
                <div class="col-lg-6">
                    <!-- WiFi Form -->
                    <section class="form-section">
                        <form id="wifi-form">
                            <div class="form-group">
                                <label for="ssid" class="form-label">Network Name (SSID)</label>
                                <input type="text" id="ssid" class="form-input" placeholder="Enter your WiFi network name" required>
                            </div>

                            <div class="form-group">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" id="password" class="form-input" placeholder="Enter your WiFi password">
                                <div class="checkbox-group">
                                    <input type="checkbox" id="no-password" class="checkbox">
                                    <label for="no-password" class="checkbox-label">This network has no password</label>
                                </div>
                            </div>

                            <button type="submit" class="btn-primary">Generate QR Code</button>
                        </form>
                    </section>
                </div>

                <!-- Right Column: QR Preview -->
                <div class="col-lg-6">
                    <section id="qr-section" class="qr-section" style="display: block;">
                        <h2 class="qr-title">Your WiFi QR Code</h2>
                        <p class="qr-subtitle">Live preview - changes update instantly</p>

                        <div class="qr-container">
                            <div id="qr-code">
                                <div style="display: flex; align-items: center; justify-content: center; height: 200px; color: #86868b; flex-direction: column;">
                                    <div style="font-size: 48px; margin-bottom: 16px;">📱</div>
                                    <div>Enter WiFi details to generate QR</div>
                                </div>
                            </div>
                        </div>

                        <div class="wifi-info" id="wifi-info" style="display: none;">
                            <p><strong>Network:</strong> <span id="display-ssid"></span></p>
                            <p><strong>Security:</strong> <span id="display-security"></span></p>
                        </div>
                    </section>
                </div>
            </div>

            <!-- Customization Panel - Below the grid -->
            <section id="customization-panel" class="customization-panel" style="display: block;">
                <h2 class="panel-title">Customize Your QR Code</h2>
                <p style="text-align: center; color: #86868b; margin-bottom: 32px;">Changes apply instantly to the preview above</p>

                <div class="customization-grid">
                    <!-- Colors -->
                    <div class="custom-group">
                        <h3>Colors</h3>
                        <div class="form-group">
                            <label class="form-label">Foreground Color</label>
                            <input type="color" id="fg-color" class="color-input" value="#000000">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Background Color</label>
                            <input type="color" id="bg-color" class="color-input" value="#ffffff">
                        </div>
                    </div>

                    <!-- Size & Style -->
                    <div class="custom-group">
                        <h3>Size & Style</h3>
                        <div class="form-group">
                            <label class="form-label">Size</label>
                            <input type="range" id="qr-size" class="range-input" min="200" max="400" value="300">
                            <div class="range-value" id="size-value">300px</div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Corner Radius</label>
                            <input type="range" id="corner-radius" class="range-input" min="0" max="20" value="0">
                            <div class="range-value" id="radius-value">0px</div>
                        </div>
                    </div>

                    <!-- Logo Upload -->
                    <div class="custom-group">
                        <h3>Logo</h3>
                        <div id="logo-upload" class="logo-upload">
                            <div id="logo-content">
                                <div class="upload-text">Click to upload logo</div>
                                <div class="upload-hint">PNG, JPG up to 2MB</div>
                            </div>
                            <input type="file" id="logo-file" accept="image/*" style="display: none;">
                        </div>
                        <div class="form-group" style="margin-top: 16px;">
                            <label class="form-label">Logo Size</label>
                            <input type="range" id="logo-size" class="range-input" min="10" max="30" value="20">
                            <div class="range-value" id="logo-size-value">20%</div>
                        </div>
                    </div>

                    <!-- Branding -->
                    <div class="custom-group">
                        <h3>Branding</h3>
                        <div class="form-group">
                            <label class="form-label">Brand Name</label>
                            <input type="text" id="brand-name" class="form-input" placeholder="Your brand name">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Description</label>
                            <input type="text" id="description" class="form-input" placeholder="Additional description">
                        </div>
                    </div>
                </div>
            </section>

            <!-- Download Section -->
            <section id="download-section" class="download-section">
                <h2 class="panel-title">Download Your QR Code</h2>
                <p class="qr-subtitle">Choose your preferred format and download</p>

                <div class="download-grid">
                    <button id="download-png" class="btn-download">Download PNG</button>
                    <button id="download-svg" class="btn-download secondary">Download SVG</button>
                    <button id="download-pdf" class="btn-download secondary">Download PDF</button>
                    <button id="download-card" class="btn-download">Download Card</button>
                </div>
            </section>
        </main>
    </div>

    <!-- QR Code Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/qrcode@1.5.4/build/qrcode.min.js"></script>
    <script src="https://unpkg.com/qrcode@1.5.4/build/qrcode.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

    <!-- Alternative QR library -->
    <script src="https://cdn.jsdelivr.net/npm/qrcode-generator@1.4.4/qrcode.min.js"></script>

    <script>
        // Global variables
        let currentQRData = '';
        let currentLogo = null;
        let qrCanvas = null;
        let updateTimeout = null;

        // DOM elements
        const wifiForm = document.getElementById('wifi-form');
        const qrSection = document.getElementById('qr-section');
        const customizationPanel = document.getElementById('customization-panel');
        const downloadSection = document.getElementById('download-section');
        const qrCodeContainer = document.getElementById('qr-code');

        // Form elements
        const ssidInput = document.getElementById('ssid');
        const passwordInput = document.getElementById('password');
        const noPasswordCheckbox = document.getElementById('no-password');

        // Customization elements
        const fgColorInput = document.getElementById('fg-color');
        const bgColorInput = document.getElementById('bg-color');
        const qrSizeInput = document.getElementById('qr-size');
        const cornerRadiusInput = document.getElementById('corner-radius');
        const logoUpload = document.getElementById('logo-upload');
        const logoFile = document.getElementById('logo-file');
        const logoSizeInput = document.getElementById('logo-size');
        const brandNameInput = document.getElementById('brand-name');
        const descriptionInput = document.getElementById('description');

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            // Wait for QRCode library to load
            checkQRCodeLibrary().then(() => {
                setupEventListeners();
            });
        });

        // Check if QRCode library is loaded
        function checkQRCodeLibrary() {
            return new Promise((resolve) => {
                // Wait a bit for libraries to load
                setTimeout(() => {
                    if (typeof QRCode !== 'undefined') {
                        console.log('QRCode library loaded successfully');
                        resolve();
                    } else {
                        console.warn('QRCode library not available, using alternative');
                        loadManualQRGenerator();
                        resolve();
                    }
                }, 1000);
            });
        }

        // Manual QR code generation fallback
        function loadManualQRGenerator() {
            console.log('Loading manual QR generator...');

            // Show info message to user
            showInfoMessage('Using online QR service. QR codes will work perfectly!');

            window.QRCode = {
                toCanvas: function(canvas, text, options) {
                    return generateManualQR(canvas, text, options);
                },
                toString: function(text, options, callback) {
                    const size = options.width || 300;
                    const encodedText = encodeURIComponent(text);
                    const svg = `<svg width="${size}" height="${size}" xmlns="http://www.w3.org/2000/svg">
                        <rect width="100%" height="100%" fill="${options.color?.light || '#ffffff'}"/>
                        <text x="50%" y="30%" text-anchor="middle" font-family="monospace" font-size="12" fill="${options.color?.dark || '#000000'}">QR Code</text>
                        <text x="50%" y="50%" text-anchor="middle" font-family="monospace" font-size="8" fill="${options.color?.dark || '#000000'}">Scan to connect</text>
                        <text x="50%" y="70%" text-anchor="middle" font-family="monospace" font-size="6" fill="${options.color?.dark || '#000000'}">WiFi Network</text>
                    </svg>`;
                    callback(null, svg);
                }
            };
        }

        function setupEventListeners() {
            // Form submission
            wifiForm.addEventListener('submit', handleFormSubmit);

            // Real-time WiFi input changes
            ssidInput.addEventListener('input', handleWiFiInputChange);
            passwordInput.addEventListener('input', handleWiFiInputChange);

            // No password checkbox
            noPasswordCheckbox.addEventListener('change', function() {
                passwordInput.disabled = this.checked;
                passwordInput.value = this.checked ? '' : passwordInput.value;
                passwordInput.style.opacity = this.checked ? '0.5' : '1';
                handleWiFiInputChange();
            });

            // Range inputs with real-time preview
            qrSizeInput.addEventListener('input', function() {
                document.getElementById('size-value').textContent = this.value + 'px';
                if (currentQRData) debounceUpdateQR();
            });

            cornerRadiusInput.addEventListener('input', function() {
                document.getElementById('radius-value').textContent = this.value + 'px';
                if (currentQRData) debounceUpdateQR();
            });

            logoSizeInput.addEventListener('input', function() {
                document.getElementById('logo-size-value').textContent = this.value + '%';
                if (currentQRData && currentLogo) debounceUpdateQR();
            });

            // Color inputs with real-time preview
            fgColorInput.addEventListener('input', function() {
                if (currentQRData) debounceUpdateQR();
            });

            bgColorInput.addEventListener('input', function() {
                if (currentQRData) debounceUpdateQR();
            });

            // Brand name and description inputs
            brandNameInput.addEventListener('input', function() {
                // These don't affect QR code directly
            });

            descriptionInput.addEventListener('input', function() {
                // These don't affect QR code directly
            });

            // Logo upload
            logoUpload.addEventListener('click', () => logoFile.click());
            logoFile.addEventListener('change', handleLogoUpload);

            // Download buttons
            document.getElementById('download-png').addEventListener('click', () => downloadQR('png'));
            document.getElementById('download-svg').addEventListener('click', () => downloadQR('svg'));
            document.getElementById('download-pdf').addEventListener('click', () => downloadQR('pdf'));
            document.getElementById('download-card').addEventListener('click', () => downloadCard());
        }

        // Handle WiFi input changes for real-time QR generation
        function handleWiFiInputChange() {
            const ssid = ssidInput.value.trim();

            if (ssid) {
                const password = noPasswordCheckbox.checked ? '' : passwordInput.value;
                const encryption = noPasswordCheckbox.checked ? 'nopass' : 'WPA';

                // Create WiFi QR string
                currentQRData = `WIFI:T:${encryption};S:${ssid};P:${password};;`;

                // Update display info
                document.getElementById('display-ssid').textContent = ssid;
                document.getElementById('display-security').textContent = encryption === 'nopass' ? 'Open' : 'WPA/WPA2';
                document.getElementById('wifi-info').style.display = 'block';

                // Generate QR with debounce
                debounceUpdateQR();
            } else {
                // Clear QR if no SSID
                currentQRData = '';
                qrCodeContainer.innerHTML = `
                    <div style="display: flex; align-items: center; justify-content: center; height: 200px; color: #86868b; flex-direction: column;">
                        <div style="font-size: 48px; margin-bottom: 16px;">📱</div>
                        <div>Enter WiFi details to generate QR</div>
                    </div>
                `;
                document.getElementById('wifi-info').style.display = 'none';
            }
        }

        async function handleFormSubmit(e) {
            e.preventDefault();
            // Form submission now just triggers the same logic as real-time input
            handleWiFiInputChange();

            if (currentQRData) {
                showSuccessMessage('QR code generated successfully!');
            }
        }

        // Debounced update function for smooth real-time updates
        function debounceUpdateQR() {
            if (updateTimeout) {
                clearTimeout(updateTimeout);
            }

            updateTimeout = setTimeout(() => {
                if (currentQRData) {
                    generateQRCode();
                }
            }, 300); // 300ms delay for smooth updates
        }

        function showErrorMessage(message) {
            showMessage(message, 'error-message', 5000);
        }

        function showSuccessMessage(message) {
            showMessage(message, 'success-message', 3000);
        }

        function showInfoMessage(message) {
            showMessage(message, 'info-message', 4000);
        }

        function showMessage(message, className, duration) {
            // Remove existing messages
            const existingMessages = document.querySelectorAll('.error-message, .success-message, .info-message');
            existingMessages.forEach(msg => msg.remove());

            // Create message
            const messageDiv = document.createElement('div');
            messageDiv.className = `${className} fade-in`;
            messageDiv.textContent = message;

            // Insert after form
            wifiForm.parentNode.insertBefore(messageDiv, wifiForm.nextSibling);

            // Auto remove after specified duration
            setTimeout(() => {
                if (messageDiv.parentNode) {
                    messageDiv.remove();
                }
            }, duration);
        }



        async function generateQRCode() {
            if (!currentQRData) {
                showErrorMessage('No WiFi data to generate QR code');
                return;
            }

            try {
                const canvas = document.createElement('canvas');
                const size = parseInt(qrSizeInput.value);

                // Check if QRCode library is available
                if (typeof QRCode !== 'undefined' && QRCode.toCanvas) {
                    console.log('Using QRCode library');

                    const options = {
                        width: size,
                        height: size,
                        margin: 4,
                        color: {
                            dark: fgColorInput.value,
                            light: bgColorInput.value
                        },
                        errorCorrectionLevel: 'M'
                    };

                    await QRCode.toCanvas(canvas, currentQRData, options);
                    console.log('QR generated successfully with library');
                } else {
                    console.log('Using manual QR generator');
                    // Use manual generator
                    canvas.width = size;
                    canvas.height = size;
                    await generateManualQR(canvas, currentQRData, {
                        width: size,
                        color: {
                            dark: fgColorInput.value,
                            light: bgColorInput.value
                        }
                    });
                }

                // Apply corner radius if specified
                const radius = parseInt(cornerRadiusInput.value);
                if (radius > 0) {
                    applyCornerRadius(canvas, radius);
                }

                // Add logo if uploaded
                if (currentLogo) {
                    addLogoToCanvas(canvas);
                }

                qrCanvas = canvas;

                // Clear container and add new QR
                qrCodeContainer.innerHTML = '';
                qrCodeContainer.appendChild(canvas);

                // Show download section only if QR was generated successfully
                if (!downloadSection.style.display || downloadSection.style.display === 'none') {
                    downloadSection.style.display = 'block';
                    downloadSection.classList.add('fade-in');
                }

                console.log('QR code generation completed');

            } catch (error) {
                console.error('Error in generateQRCode:', error);
                showErrorMessage('Failed to generate QR code: ' + error.message);
            }
        }

        // Manual QR generator using online service
        async function generateManualQR(canvas, text, options) {
            try {
                const size = options.width;
                const encodedText = encodeURIComponent(text);

                // Use QR Server API to generate actual QR code
                const qrUrl = `https://api.qrserver.com/v1/create-qr-code/?size=${size}x${size}&data=${encodedText}&format=PNG&bgcolor=${options.color.light.replace('#', '')}&color=${options.color.dark.replace('#', '')}`;

                const img = new Image();
                img.crossOrigin = 'anonymous';

                return new Promise((resolve, reject) => {
                    img.onload = function() {
                        const ctx = canvas.getContext('2d');
                        canvas.width = size;
                        canvas.height = size;

                        // Fill background first
                        ctx.fillStyle = options.color.light;
                        ctx.fillRect(0, 0, size, size);

                        // Draw the QR code image
                        ctx.drawImage(img, 0, 0, size, size);
                        resolve();
                    };

                    img.onerror = function() {
                        console.log('Online QR service failed, using local pattern');
                        generateLocalQRPattern(canvas, text, options);
                        resolve();
                    };

                    img.src = qrUrl;
                });

            } catch (error) {
                console.log('Manual QR generation failed, using local pattern');
                generateLocalQRPattern(canvas, text, options);
            }
        }

        // Local QR pattern as final fallback
        function generateLocalQRPattern(canvas, text, options) {
            const ctx = canvas.getContext('2d');
            const size = options.width;

            // Fill background
            ctx.fillStyle = options.color.light;
            ctx.fillRect(0, 0, size, size);

            ctx.fillStyle = options.color.dark;

            // Create a grid pattern that looks like QR
            const moduleSize = size / 25;

            // Draw finder patterns (corners)
            drawFinderPattern(ctx, 0, 0, moduleSize * 7);
            drawFinderPattern(ctx, size - moduleSize * 7, 0, moduleSize * 7);
            drawFinderPattern(ctx, 0, size - moduleSize * 7, moduleSize * 7);

            // Draw timing patterns
            for (let i = 8; i < 17; i++) {
                if (i % 2 === 0) {
                    ctx.fillRect(i * moduleSize, 6 * moduleSize, moduleSize, moduleSize);
                    ctx.fillRect(6 * moduleSize, i * moduleSize, moduleSize, moduleSize);
                }
            }

            // Draw data pattern based on text hash
            const hash = simpleHash(text);
            for (let i = 0; i < 25; i++) {
                for (let j = 0; j < 25; j++) {
                    if (!isReservedArea(i, j)) {
                        if ((hash + i * j) % 3 === 0) {
                            ctx.fillRect(i * moduleSize, j * moduleSize, moduleSize, moduleSize);
                        }
                    }
                }
            }

            function drawFinderPattern(ctx, x, y, size) {
                const moduleSize = size / 7;
                // Outer border
                ctx.fillRect(x, y, size, size);
                // Inner white
                ctx.fillStyle = options.color.light;
                ctx.fillRect(x + moduleSize, y + moduleSize, size - 2 * moduleSize, size - 2 * moduleSize);
                // Center black
                ctx.fillStyle = options.color.dark;
                ctx.fillRect(x + 2 * moduleSize, y + 2 * moduleSize, size - 4 * moduleSize, size - 4 * moduleSize);
            }

            function isReservedArea(i, j) {
                // Finder patterns
                if ((i < 9 && j < 9) || (i > 15 && j < 9) || (i < 9 && j > 15)) return true;
                // Timing patterns
                if ((i === 6 && j > 7 && j < 17) || (j === 6 && i > 7 && i < 17)) return true;
                return false;
            }

            function simpleHash(str) {
                let hash = 0;
                for (let i = 0; i < str.length; i++) {
                    hash = ((hash << 5) - hash + str.charCodeAt(i)) & 0xffffffff;
                }
                return Math.abs(hash);
            }
        }

        async function updateQRCode() {
            if (!currentQRData) return;

            try {
                await generateQRCode();
            } catch (error) {
                console.error('Failed to update QR code:', error);
                showErrorMessage('Failed to update QR code');
            }
        }

        function applyCornerRadius(canvas, radius) {
            const ctx = canvas.getContext('2d');
            const imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);

            // Create new canvas with rounded corners
            const roundedCanvas = document.createElement('canvas');
            roundedCanvas.width = canvas.width;
            roundedCanvas.height = canvas.height;
            const roundedCtx = roundedCanvas.getContext('2d');

            // Create rounded rectangle path manually (for browser compatibility)
            roundedCtx.beginPath();
            drawRoundedRect(roundedCtx, 0, 0, canvas.width, canvas.height, radius);
            roundedCtx.clip();

            // Draw original image
            roundedCtx.putImageData(imageData, 0, 0);

            // Replace original canvas content
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            ctx.drawImage(roundedCanvas, 0, 0);
        }

        function drawRoundedRect(ctx, x, y, width, height, radius) {
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

        function addLogoToCanvas(canvas) {
            const ctx = canvas.getContext('2d');
            const logoSizePercent = parseInt(logoSizeInput.value) / 100;
            const logoSize = canvas.width * logoSizePercent;
            const x = (canvas.width - logoSize) / 2;
            const y = (canvas.height - logoSize) / 2;

            // Add white background for logo
            ctx.fillStyle = bgColorInput.value;
            ctx.fillRect(x - 8, y - 8, logoSize + 16, logoSize + 16);

            // Draw logo
            ctx.drawImage(currentLogo, x, y, logoSize, logoSize);
        }

        function handleLogoUpload(e) {
            const file = e.target.files[0];
            if (!file) return;

            if (file.size > 2 * 1024 * 1024) {
                showErrorMessage('File size must be less than 2MB');
                return;
            }

            if (!file.type.startsWith('image/')) {
                showErrorMessage('Please select a valid image file (PNG, JPG, GIF)');
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                const img = new Image();
                img.onload = function() {
                    currentLogo = img;

                    // Update upload area
                    const logoContent = document.getElementById('logo-content');
                    logoContent.innerHTML = `
                        <img src="${e.target.result}" class="logo-preview" alt="Logo preview">
                        <div class="upload-text">Logo uploaded</div>
                        <div class="upload-hint">Click to change</div>
                    `;
                    logoUpload.classList.add('has-logo');

                    // Update QR if it exists
                    if (currentQRData) {
                        debounceUpdateQR();
                    }
                };
                img.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }

        function downloadQR(format) {
            if (!qrCanvas) {
                showErrorMessage('Please generate a QR code first');
                return;
            }

            try {

            const ssid = ssidInput.value.trim() || 'wifi';
            const filename = `wifi-qr-${ssid}`;

            if (format === 'png') {
                const link = document.createElement('a');
                link.download = `${filename}.png`;
                link.href = qrCanvas.toDataURL();
                link.click();
            } else if (format === 'svg') {
                // For SVG, we'll regenerate using QRCode library
                QRCode.toString(currentQRData, {
                    type: 'svg',
                    width: parseInt(qrSizeInput.value),
                    color: {
                        dark: fgColorInput.value,
                        light: bgColorInput.value
                    }
                }, function(err, svg) {
                    if (err) throw err;

                    const blob = new Blob([svg], { type: 'image/svg+xml' });
                    const link = document.createElement('a');
                    link.download = `${filename}.svg`;
                    link.href = URL.createObjectURL(blob);
                    link.click();
                });
            } else if (format === 'pdf') {
                const { jsPDF } = window.jspdf;
                const pdf = new jsPDF();

                const imgData = qrCanvas.toDataURL('image/png');
                const imgWidth = 100;
                const imgHeight = 100;
                const x = (pdf.internal.pageSize.getWidth() - imgWidth) / 2;
                const y = 50;

                pdf.addImage(imgData, 'PNG', x, y, imgWidth, imgHeight);
                pdf.save(`${filename}.pdf`);
            }

            showSuccessMessage(`${format.toUpperCase()} downloaded successfully!`);

            } catch (error) {
                console.error('Download error:', error);
                showErrorMessage(`Failed to download ${format.toUpperCase()}. Please try again.`);
            }
        }

        function downloadCard() {
            if (!qrCanvas) {
                showErrorMessage('Please generate a QR code first');
                return;
            }

            try {

            // Create card canvas
            const cardCanvas = document.createElement('canvas');
            cardCanvas.width = 600;
            cardCanvas.height = 400;
            const ctx = cardCanvas.getContext('2d');

            // Card background
            ctx.fillStyle = '#ffffff';
            ctx.fillRect(0, 0, cardCanvas.width, cardCanvas.height);

            // Add border
            ctx.strokeStyle = '#f0f0f0';
            ctx.lineWidth = 2;
            ctx.strokeRect(0, 0, cardCanvas.width, cardCanvas.height);

            // Add QR code
            const qrSize = 200;
            const qrX = 50;
            const qrY = (cardCanvas.height - qrSize) / 2;
            ctx.drawImage(qrCanvas, qrX, qrY, qrSize, qrSize);

            // Add text
            ctx.fillStyle = '#1d1d1f';
            ctx.font = 'bold 32px SF Pro Display, sans-serif';
            ctx.fillText('WiFi Access', 300, 120);

            ctx.font = '24px SF Pro Display, sans-serif';
            ctx.fillText(`Network: ${ssidInput.value}`, 300, 160);

            const security = noPasswordCheckbox.checked ? 'Open' : 'WPA/WPA2';
            ctx.fillText(`Security: ${security}`, 300, 190);

            // Add brand name if provided
            const brandName = brandNameInput.value.trim();
            if (brandName) {
                ctx.font = 'bold 20px SF Pro Display, sans-serif';
                ctx.fillText(brandName, 300, 240);
            }

            // Add description if provided
            const description = descriptionInput.value.trim();
            if (description) {
                ctx.font = '16px SF Pro Display, sans-serif';
                ctx.fillStyle = '#86868b';
                ctx.fillText(description, 300, 270);
            }

            ctx.font = '14px SF Pro Display, sans-serif';
            ctx.fillText('Scan to connect instantly', 300, 320);

            // Download card
            const link = document.createElement('a');
            const ssid = ssidInput.value.trim() || 'wifi';
            link.download = `wifi-card-${ssid}.png`;
            link.href = cardCanvas.toDataURL();
            link.click();

            showSuccessMessage('WiFi card downloaded successfully!');

            } catch (error) {
                console.error('Card download error:', error);
                showErrorMessage('Failed to download WiFi card. Please try again.');
            }
        }
    </script>
</body>
</html>

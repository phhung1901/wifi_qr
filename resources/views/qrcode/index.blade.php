<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>WiFi QR Code Generator - Tùy chỉnh & Tạo Poster</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('css/qr-customizer.css') }}" rel="stylesheet">

    <!-- QR Code Libraries -->
    <script src="https://unpkg.com/qrcode@1.5.4/build/qrcode.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/qrcode-generator@1.4.4/qrcode.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fabric@6.7.0/dist/fabric.min.js"></script>
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h3 class="mb-0"><i class="bi bi-qr-code"></i> Tạo mã QR kết nối WiFi</h3>
                        <p class="mb-0 mt-2">Tùy chỉnh màu sắc, logo và tạo poster đẹp mắt</p>
                    </div>
                    <div class="card-body">
                        <form id="wifi-form" class="mb-4">
                            @csrf
                            <div class="mb-3">
                                <label for="ssid" class="form-label">Tên WiFi (SSID)</label>
                                <input type="text" class="form-control" id="ssid" name="ssid" required>
                                <small class="form-text text-muted">Tên WiFi của bạn, xem trên điện thoại hoặc router</small>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Mật khẩu WiFi</label>
                                <input type="password" class="form-control" id="password" name="password">
                                <div class="form-check mt-2">
                                    <input class="form-check-input" type="checkbox" id="show-password">
                                    <label class="form-check-label" for="show-password">
                                        Hiển thị mật khẩu
                                    </label>
                                </div>
                                <div class="form-check mt-2">
                                    <input class="form-check-input" type="checkbox" id="no-password">
                                    <label class="form-check-label" for="no-password">
                                        WiFi không có mật khẩu
                                    </label>
                                </div>
                            </div>
                            <input type="hidden" name="encryption" id="encryption" value="WPA">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-qr-code-scan"></i> Tạo mã QR
                            </button>
                        </form>

                        <!-- QR Customizer -->
                        <div id="qr-customizer" class="qr-customizer d-none fade-in">
                            <h4><i class="bi bi-palette"></i> Tùy chỉnh giao diện</h4>

                            <!-- Color Customization -->
                            <div class="customizer-section">
                                <h6><i class="bi bi-palette-fill"></i> Màu sắc</h6>
                                <div class="color-picker-group">
                                    <div class="color-picker-item">
                                        <label for="qr-fg-color">Màu mã QR</label>
                                        <input type="color" id="qr-fg-color" class="color-picker" value="#000000">
                                    </div>
                                    <div class="color-picker-item">
                                        <label for="qr-bg-color">Màu nền</label>
                                        <input type="color" id="qr-bg-color" class="color-picker" value="#ffffff">
                                    </div>
                                </div>
                            </div>

                            <!-- Size and Style -->
                            <div class="customizer-section">
                                <h6><i class="bi bi-aspect-ratio"></i> Kích thước & Kiểu dáng</h6>
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="qr-size">Kích thước</label>
                                        <input type="range" id="qr-size" class="size-slider" min="128" max="512" value="256">
                                        <span id="size-display" class="size-display">256px</span>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="corner-radius">Bo góc</label>
                                        <input type="range" id="corner-radius" class="size-slider" min="0" max="20" value="0">
                                        <span id="corner-radius-display" class="size-display">0px</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Logo Upload -->
                            <div class="customizer-section">
                                <h6><i class="bi bi-image"></i> Logo (tùy chọn)</h6>
                                <div id="logo-upload-area" class="logo-upload-area">
                                    <i class="bi bi-cloud-upload" style="font-size: 2rem; color: #667eea;"></i>
                                    <p class="mb-2">Kéo thả hoặc click để chọn logo</p>
                                    <small class="text-muted">PNG, JPG, GIF (tối đa 2MB)</small>
                                    <input type="file" id="logo-upload" accept="image/*" style="display: none;">
                                </div>
                                <div class="mt-3">
                                    <label for="logo-size">Kích thước logo</label>
                                    <input type="range" id="logo-size" class="size-slider" min="0.1" max="0.4" step="0.05" value="0.2">
                                    <span id="logo-size-display" class="size-display">20%</span>
                                </div>
                            </div>
                        </div>

                        <div id="qrcode-container" class="text-center d-none fade-in">
                            <div class="alert alert-warning">
                                <i class="bi bi-exclamation-triangle"></i> Lưu ý: Không chia sẻ mã QR này nếu bạn không muốn người khác biết mật khẩu WiFi của bạn.
                            </div>

                            <!-- QR Preview -->
                            <div class="qr-preview-container">
                                <h5><i class="bi bi-qr-code"></i> Mã QR của bạn</h5>
                                <div id="qr-preview" class="qr-preview"></div>

                                <!-- Download Options -->
                                <div class="download-options">
                                    <button id="download-qr-png" class="download-btn primary">
                                        <i class="bi bi-download"></i> Tải QR (PNG)
                                    </button>
                                </div>
                            </div>

                            <!-- Template Selector -->
                            <div class="customizer-section">
                                <h6><i class="bi bi-layout-text-window-reverse"></i> Chọn template poster</h6>
                                <div id="template-selector" class="template-selector"></div>

                                <!-- Poster Size Selector -->
                                <div class="mt-3">
                                    <label for="poster-size-selector">Kích thước poster:</label>
                                    <select id="poster-size-selector" class="form-select">
                                        <option value="a5">A5 (148×210mm)</option>
                                        <option value="a4">A4 (210×297mm)</option>
                                        <option value="card">Card (84×119mm)</option>
                                        <option value="square">Vuông (200×200mm)</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Poster Preview -->
                            <div class="qr-preview-container">
                                <h5><i class="bi bi-image"></i> Xem trước poster</h5>
                                <div id="poster-preview" style="max-height: 400px; overflow: auto;"></div>

                                <!-- Poster Download Options -->
                                <div class="download-options">
                                    <button id="convert-qr" class="download-btn" style="background: #ffc107; color: #000;">
                                        <i class="bi bi-arrow-repeat"></i> Convert QR
                                    </button>
                                    <button id="test-poster" class="download-btn" style="background: #28a745;">
                                        <i class="bi bi-bug"></i> Test Poster
                                    </button>
                                    <button id="download-poster-png" class="download-btn secondary">
                                        <i class="bi bi-file-earmark-image"></i> Tải Poster (PNG)
                                    </button>
                                    <button id="download-poster-pdf" class="download-btn secondary">
                                        <i class="bi bi-file-earmark-pdf"></i> Tải Poster (PDF)
                                    </button>
                                </div>
                            </div>

                            <!-- WiFi Info -->
                            <div class="card mb-3">
                                <div class="card-header"><i class="bi bi-wifi"></i> Thông tin WiFi</div>
                                <div class="card-body">
                                    <p><strong>Tên mạng:</strong> <span id="info-ssid"></span></p>
                                    <p><strong>Mã hóa:</strong> <span id="info-encryption"></span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Custom Scripts -->
    <script src="{{ asset('js/qr-customizer.js') }}"></script>
    <script src="{{ asset('js/poster-generator.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('wifi-form');
            const qrcodeContainer = document.getElementById('qrcode-container');
            const qrCustomizer = document.getElementById('qr-customizer');
            const showPasswordCheckbox = document.getElementById('show-password');
            const noPasswordCheckbox = document.getElementById('no-password');
            const passwordInput = document.getElementById('password');
            const encryptionInput = document.getElementById('encryption');
            const infoSsid = document.getElementById('info-ssid');
            const infoEncryption = document.getElementById('info-encryption');

            // Initialize poster generator
            let posterGenerator = null;

            // Show/hide password
            showPasswordCheckbox.addEventListener('change', function() {
                passwordInput.type = this.checked ? 'text' : 'password';
            });

            // Handle no password checkbox
            noPasswordCheckbox.addEventListener('change', function() {
                if (this.checked) {
                    passwordInput.value = '';
                    passwordInput.disabled = true;
                    showPasswordCheckbox.disabled = true;
                    encryptionInput.value = 'nopass';
                } else {
                    passwordInput.disabled = false;
                    showPasswordCheckbox.disabled = false;
                    encryptionInput.value = 'WPA';
                }
            });

            form.addEventListener('submit', function(e) {
                e.preventDefault();

                const formData = new FormData(form);
                const ssid = formData.get('ssid');
                const password = formData.get('password');
                const encryption = formData.get('encryption');

                fetch('{{ route("wifi-qr.generate") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        ssid: ssid,
                        password: password,
                        encryption: encryption
                    })
                })
                .then(response => response.json())
                .then(data => {
                    // Generate basic QR code immediately
                    generateBasicQR(data.wifiString, ssid);

                    // Show customizer and QR container
                    qrCustomizer.classList.remove('d-none');
                    qrcodeContainer.classList.remove('d-none');

                    // Update info
                    infoSsid.textContent = ssid;
                    infoEncryption.textContent = encryption === 'nopass' ? 'Không mã hóa' : encryption;

                    // Initialize poster generator if not already done
                    if (!posterGenerator) {
                        posterGenerator = new PosterGenerator();
                    }

                    // Initialize QR customizer with current data
                    if (window.initializeQRCustomizer) {
                        const customizer = window.initializeQRCustomizer();

                        // Initialize with WiFi data
                        customizer.initWithWifiData(data.wifiString, {
                            ssid: ssid,
                            encryption: encryption
                        });

                        // Setup real-time customization listeners
                        setupCustomizationListeners();

                        // Generate initial poster with simple template
                        setTimeout(() => {
                            if (window.globalPosterGenerator && window.qrCustomizer) {
                                console.log('Generating initial poster...');
                                window.qrCustomizer.updatePosterPreview();
                            }
                        }, 1000);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Có lỗi xảy ra khi tạo mã QR.');
                });
            });

            // Function to generate basic QR code immediately
            function generateBasicQR(wifiString, ssid) {
                console.log('Generating basic QR for:', wifiString);
                const preview = document.getElementById('qr-preview');
                if (!preview) {
                    console.error('QR preview element not found');
                    return;
                }

                preview.innerHTML = '<div class="text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Đang tạo QR...</span></div></div>';

                // Try modern QRCode library first
                if (typeof QRCode !== 'undefined' && QRCode.toCanvas) {
                    try {
                        const canvas = document.createElement('canvas');

                        QRCode.toCanvas(canvas, wifiString, {
                            width: 256,
                            margin: 4,
                            color: {
                                dark: '#000000',
                                light: '#ffffff'
                            }
                        }).then(() => {
                            console.log('QR code generated successfully with modern library');
                            preview.innerHTML = '';
                            preview.appendChild(canvas);
                            setupDownloadButton(canvas, ssid);
                        }).catch(error => {
                            console.error('Error with modern QRCode:', error);
                            generateBasicQRFallback(wifiString, ssid, preview);
                        });
                    } catch (error) {
                        console.error('Error with modern QRCode (sync):', error);
                        generateBasicQRFallback(wifiString, ssid, preview);
                    }
                } else {
                    // Fallback to old qrcode-generator library
                    generateBasicQRFallback(wifiString, ssid, preview);
                }
            }

            // Fallback function using old qrcode-generator library
            function generateBasicQRFallback(wifiString, ssid, preview) {
                console.log('Using fallback QR generator');
                if (typeof qrcode !== 'undefined') {
                    try {
                        const qr = qrcode(0, 'M');
                        qr.addData(wifiString);
                        qr.make();

                        const qrImage = qr.createImgTag(5);
                        preview.innerHTML = qrImage;

                        // Setup download for image
                        const img = preview.querySelector('img');
                        if (img) {
                            setupDownloadButtonForImg(img, ssid);
                        }

                        console.log('QR code generated with fallback library');
                    } catch (error) {
                        console.error('Error with fallback QR generator:', error);
                        // Last resort: use online QR API
                        generateQRWithAPI(wifiString, ssid, preview);
                    }
                } else {
                    console.log('Fallback library not available, using API');
                    // Last resort: use online QR API
                    generateQRWithAPI(wifiString, ssid, preview);
                }
            }

            // Last resort: use online QR API
            function generateQRWithAPI(wifiString, ssid, preview) {
                console.log('Using online QR API');
                const encodedData = encodeURIComponent(wifiString);
                const qrUrl = `https://api.qrserver.com/v1/create-qr-code/?size=256x256&data=${encodedData}`;

                const img = document.createElement('img');
                img.src = qrUrl;
                img.alt = 'WiFi QR Code';
                img.style.maxWidth = '100%';
                img.style.height = 'auto';

                img.onload = function() {
                    preview.innerHTML = '';
                    preview.appendChild(img);
                    setupDownloadButtonForImg(img, ssid);
                    console.log('QR code generated with online API');
                };

                img.onerror = function() {
                    console.error('Error loading QR from API');
                    preview.innerHTML = '<p class="text-danger">Không thể tạo mã QR. Vui lòng kiểm tra kết nối internet.</p>';
                };
            }

            // Setup download button for canvas
            function setupDownloadButton(canvas, ssid) {
                const downloadBtn = document.getElementById('download-qr-png');
                if (downloadBtn) {
                    downloadBtn.onclick = function() {
                        const link = document.createElement('a');
                        link.download = `wifi-qr-${ssid}.png`;
                        link.href = canvas.toDataURL();
                        link.click();
                    };
                }
            }

            // Setup download button for image
            function setupDownloadButtonForImg(img, ssid) {
                const downloadBtn = document.getElementById('download-qr-png');
                if (downloadBtn) {
                    downloadBtn.onclick = function() {
                        const link = document.createElement('a');
                        link.download = `wifi-qr-${ssid}.png`;
                        link.href = img.src;
                        link.click();
                    };
                }
            }

            // Setup real-time customization listeners
            function setupCustomizationListeners() {
                // Color change listeners
                const fgColorPicker = document.getElementById('qr-fg-color');
                const bgColorPicker = document.getElementById('qr-bg-color');
                const sizeSlider = document.getElementById('qr-size');
                const cornerRadiusSlider = document.getElementById('corner-radius');
                const logoSizeSlider = document.getElementById('logo-size');

                if (fgColorPicker) {
                    fgColorPicker.addEventListener('change', function() {
                        if (window.qrCustomizer) {
                            window.qrCustomizer.qrOptions.foregroundColor = this.value;
                            window.qrCustomizer.updateQRPreview();
                        }
                    });
                }

                if (bgColorPicker) {
                    bgColorPicker.addEventListener('change', function() {
                        if (window.qrCustomizer) {
                            window.qrCustomizer.qrOptions.backgroundColor = this.value;
                            window.qrCustomizer.updateQRPreview();
                        }
                    });
                }

                if (sizeSlider) {
                    sizeSlider.addEventListener('input', function() {
                        if (window.qrCustomizer) {
                            window.qrCustomizer.qrOptions.size = parseInt(this.value);
                            document.getElementById('size-display').textContent = this.value + 'px';
                            window.qrCustomizer.updateQRPreview();
                        }
                    });
                }

                if (cornerRadiusSlider) {
                    cornerRadiusSlider.addEventListener('input', function() {
                        if (window.qrCustomizer) {
                            window.qrCustomizer.qrOptions.cornerRadius = parseInt(this.value);
                            document.getElementById('corner-radius-display').textContent = this.value + 'px';
                            window.qrCustomizer.updateQRPreview();
                        }
                    });
                }

                if (logoSizeSlider) {
                    logoSizeSlider.addEventListener('input', function() {
                        if (window.qrCustomizer) {
                            window.qrCustomizer.qrOptions.logoSize = parseFloat(this.value);
                            document.getElementById('logo-size-display').textContent = Math.round(this.value * 100) + '%';
                            window.qrCustomizer.updateQRPreview();
                        }
                    });
                }
            }

            // Enhanced poster generation
            document.addEventListener('click', function(e) {
                if (e.target.closest('.template-card')) {
                    const templateCard = e.target.closest('.template-card');
                    const template = templateCard.dataset.template;

                    console.log('Template selected:', template);

                    // Remove active class from all cards
                    document.querySelectorAll('.template-card').forEach(card => {
                        card.classList.remove('active');
                    });

                    // Add active class to clicked card
                    templateCard.classList.add('active');

                    if (window.qrCustomizer) {
                        window.qrCustomizer.selectTemplate(template);
                    } else {
                        console.error('QR Customizer not available');
                    }
                }
            });

            // Convert QR button
            document.getElementById('convert-qr').addEventListener('click', function() {
                console.log('Converting QR image to canvas...');

                if (!window.qrCustomizer) {
                    alert('QR Customizer not initialized!');
                    return;
                }

                // Force convert existing QR to canvas
                window.qrCustomizer.convertExistingQRToCanvas();

                // Update poster after conversion
                setTimeout(() => {
                    if (window.qrCustomizer) {
                        window.qrCustomizer.updatePosterPreview();
                    }
                }, 100);
            });

            // Test poster button
            document.getElementById('test-poster').addEventListener('click', function() {
                console.log('Testing poster generation...');

                if (!window.globalPosterGenerator) {
                    alert('Poster generator not initialized! Please create QR first.');
                    return;
                }

                // Get actual QR canvas from the page
                let qrCanvas = document.querySelector('#qr-preview canvas');
                if (!qrCanvas) {
                    // Try to get from QR container (fallback img)
                    const qrImg = document.querySelector('#qrcode img');
                    if (qrImg) {
                        // Convert img to canvas
                        qrCanvas = document.createElement('canvas');
                        qrCanvas.width = 256;
                        qrCanvas.height = 256;
                        const ctx = qrCanvas.getContext('2d');
                        ctx.drawImage(qrImg, 0, 0, 256, 256);
                        console.log('Converted QR img to canvas');
                    }
                }

                if (!qrCanvas) {
                    // Create test QR canvas as fallback
                    qrCanvas = document.createElement('canvas');
                    qrCanvas.width = 256;
                    qrCanvas.height = 256;
                    const testCtx = qrCanvas.getContext('2d');
                    testCtx.fillStyle = '#000';
                    testCtx.fillRect(50, 50, 156, 156);
                    testCtx.fillStyle = '#fff';
                    testCtx.fillRect(75, 75, 106, 106);
                    console.log('Created test QR canvas');
                }

                console.log('Using QR canvas:', qrCanvas.width, 'x', qrCanvas.height);

                // Generate poster with actual WiFi info
                const wifiInfo = {
                    ssid: document.getElementById('ssid').value || 'TestWiFi',
                    encryption: document.getElementById('encryption').value || 'WPA'
                };

                window.globalPosterGenerator.generatePoster('simple', qrCanvas, wifiInfo);
            });

            // Enhanced download functionality
            document.getElementById('download-poster-png').addEventListener('click', function() {
                if (window.globalPosterGenerator) {
                    const ssid = document.getElementById('ssid').value || 'wifi';
                    window.globalPosterGenerator.downloadPoster('png', `wifi-poster-${ssid}`);
                } else {
                    alert('Poster chưa được tạo! Vui lòng chọn template trước.');
                }
            });

            document.getElementById('download-poster-pdf').addEventListener('click', function() {
                if (window.globalPosterGenerator) {
                    const ssid = document.getElementById('ssid').value || 'wifi';
                    window.globalPosterGenerator.downloadPoster('pdf', `wifi-poster-${ssid}`);
                } else {
                    alert('Poster chưa được tạo! Vui lòng chọn template trước.');
                }
            });
        });
    </script>
</body>
</html>

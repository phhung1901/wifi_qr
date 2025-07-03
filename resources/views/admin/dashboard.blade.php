<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WiFi QR Generator - Admin Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #f5f5f7;
            color: #1d1d1f;
        }

        .header {
            background: white;
            padding: 20px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }

        .header h1 {
            font-size: 28px;
            font-weight: 600;
        }

        .header p {
            color: #86868b;
            margin-top: 5px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 24px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .stat-card h3 {
            font-size: 14px;
            color: #86868b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }

        .stat-card .number {
            font-size: 32px;
            font-weight: 700;
            color: #1d1d1f;
            margin-bottom: 4px;
        }

        .stat-card .subtitle {
            font-size: 14px;
            color: #86868b;
        }

        .charts-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .chart-card {
            background: white;
            padding: 24px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .chart-card h3 {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .chart-container {
            position: relative;
            height: 300px;
        }

        .table-card {
            background: white;
            padding: 24px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }

        .table-card h3 {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            text-align: left;
            padding: 12px;
            border-bottom: 1px solid #f0f0f0;
        }

        th {
            font-weight: 600;
            color: #86868b;
            font-size: 14px;
        }

        .badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 500;
        }

        .badge-primary {
            background: #007aff;
            color: white;
        }

        .badge-success {
            background: #34c759;
            color: white;
        }

        .badge-warning {
            background: #ff9500;
            color: white;
        }

        .date-filter {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }

        .date-filter h3 {
            margin-bottom: 15px;
        }

        .date-inputs {
            display: flex;
            gap: 15px;
            align-items: end;
        }

        .date-inputs input {
            padding: 8px 12px;
            border: 1px solid #d2d2d7;
            border-radius: 8px;
            font-size: 14px;
        }

        .btn {
            padding: 8px 16px;
            background: #007aff;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
        }

        .btn:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="container">
            <h1>WiFi QR Generator Dashboard</h1>
            <p>Real-time analytics and download statistics</p>
        </div>
    </div>

    <div class="container">
        <!-- Date Range Filter -->
        <div class="date-filter">
            <h3>Custom Date Range & Export</h3>
            <div class="date-inputs">
                <div>
                    <label>Start Date:</label>
                    <input type="date" id="start-date" value="{{ date('Y-m-d', strtotime('-7 days')) }}">
                </div>
                <div>
                    <label>End Date:</label>
                    <input type="date" id="end-date" value="{{ date('Y-m-d') }}">
                </div>
                <button class="btn" onclick="loadCustomStats()">Load Stats</button>
                <button class="btn" onclick="exportData()" style="background: #34c759;">Export CSV</button>
            </div>
            <div id="custom-stats" style="margin-top: 15px; display: none;">
                <!-- Custom stats will be loaded here -->
            </div>
        </div>

        <!-- Main Stats -->
        <div class="stats-grid">
            <div class="stat-card">
                <h3>Today</h3>
                <div class="number">{{ number_format($stats['today']['downloads']) }}</div>
                <div class="subtitle">Downloads {{ $stats['today']['downloads'] == 0 ? '(No real data yet)' : '' }}</div>
            </div>
            <div class="stat-card">
                <h3>This Week</h3>
                <div class="number">{{ number_format($stats['week']['downloads']) }}</div>
                <div class="subtitle">Downloads {{ $stats['week']['downloads'] == 0 ? '(No real data yet)' : '' }}</div>
            </div>
            <div class="stat-card">
                <h3>This Month</h3>
                <div class="number">{{ number_format($stats['month']['downloads']) }}</div>
                <div class="subtitle">Downloads {{ $stats['month']['downloads'] == 0 ? '(No real data yet)' : '' }}</div>
            </div>
            <div class="stat-card">
                <h3>Total</h3>
                <div class="number">{{ number_format($stats['total']) }}</div>
                <div class="subtitle">All Time Downloads {{ $stats['total'] == 0 ? '(No real data yet)' : '' }}</div>
            </div>
        </div>

        @if($stats['total'] == 0)
        <div style="background: #fff3cd; border: 1px solid #ffeaa7; border-radius: 12px; padding: 20px; margin-bottom: 30px; text-align: center;">
            <h3 style="color: #856404; margin-bottom: 10px;">📊 No Real Data Yet</h3>
            <p style="color: #856404; margin: 0;">
                The dashboard will show real statistics once users start downloading QR codes.
                Try downloading a QR code from the main page to see real data appear here.
            </p>
        </div>
        @else
        <div style="background: #d4edda; border: 1px solid #c3e6cb; border-radius: 12px; padding: 20px; margin-bottom: 30px; text-align: center;">
            <h3 style="color: #155724; margin-bottom: 10px;">✅ Real Data Active</h3>
            <p style="color: #155724; margin: 0;">
                Dashboard is showing real user activity data. All statistics are based on actual downloads from users.
                <br><strong>Last activity:</strong> {{ \App\Models\QrDownload::latest()->first()?->created_at?->diffForHumans() ?? 'No activity yet' }}
            </p>
        </div>
        @endif

        <!-- User Stats -->
        <div class="stats-grid">
            <div class="stat-card">
                <h3>Unique Users Today</h3>
                <div class="number">{{ number_format($stats['today']['unique_users']) }}</div>
                <div class="subtitle">{{ $stats['today']['avg_per_user'] }} avg downloads/user</div>
            </div>
            <div class="stat-card">
                <h3>Unique Users This Week</h3>
                <div class="number">{{ number_format($stats['week']['unique_users']) }}</div>
                <div class="subtitle">{{ $stats['week']['avg_per_user'] }} avg downloads/user</div>
            </div>
            <div class="stat-card">
                <h3>Unique Users This Month</h3>
                <div class="number">{{ number_format($stats['month']['unique_users']) }}</div>
                <div class="subtitle">{{ $stats['month']['avg_per_user'] }} avg downloads/user</div>
            </div>
            <div class="stat-card">
                <h3>Growth Rate (Week)</h3>
                <div class="number" style="color: {{ $analyticsData['growth_rates']['week']['is_positive'] ? '#34c759' : '#ff3b30' }}">
                    {{ $analyticsData['growth_rates']['week']['growth_rate'] }}%
                </div>
                <div class="subtitle">vs previous week</div>
            </div>
        </div>

        <!-- Advanced Analytics -->
        <div class="stats-grid">
            <div class="stat-card">
                <h3>Conversion Rate (Week)</h3>
                <div class="number">{{ $analyticsData['conversion_rates']['week']['conversion_rate'] }}%</div>
                <div class="subtitle">{{ number_format($analyticsData['conversion_rates']['week']['downloads']) }} downloads / {{ number_format($analyticsData['conversion_rates']['week']['estimated_page_views']) }} estimated views</div>
            </div>
            <div class="stat-card">
                <h3>Logo Usage</h3>
                <div class="number">{{ $analyticsData['customization_stats']['logo_percentage'] }}%</div>
                <div class="subtitle">{{ number_format($analyticsData['customization_stats']['with_logo']) }} downloads with logo</div>
            </div>
            <div class="stat-card">
                <h3>Custom Colors</h3>
                <div class="number">{{ $analyticsData['customization_stats']['colors_percentage'] }}%</div>
                <div class="subtitle">{{ number_format($analyticsData['customization_stats']['with_custom_colors']) }} downloads with custom colors</div>
            </div>
            <div class="stat-card">
                <h3>Peak Hour</h3>
                <div class="number">{{ $analyticsData['peak_hours'][0]['hour'] ?? 'N/A' }}</div>
                <div class="subtitle">{{ $analyticsData['peak_hours'][0]['downloads'] ?? 0 }} downloads</div>
            </div>
        </div>

        <!-- Charts -->
        <div class="charts-grid">
            <div class="chart-card">
                <h3>Daily Downloads (Last 30 Days)</h3>
                <div class="chart-container">
                    <canvas id="dailyChart"></canvas>
                </div>
            </div>
            <div class="chart-card">
                <h3>Hourly Distribution (Today)</h3>
                <div class="chart-container">
                    <canvas id="hourlyChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Additional Charts -->
        <div class="charts-grid">
            <div class="chart-card">
                <h3>Device Distribution</h3>
                <div class="chart-container">
                    <canvas id="deviceChart"></canvas>
                </div>
            </div>
            <div class="chart-card">
                <h3>Traffic Sources</h3>
                <div class="chart-container">
                    <canvas id="referrerChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Tables -->
        <div class="charts-grid">
            <div class="table-card">
                <h3>Popular Download Types</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>Downloads</th>
                            <th>Percentage</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($popularTypes as $type)
                        <tr>
                            <td>
                                <span class="badge badge-primary">{{ strtoupper($type['download_type']) }}</span>
                            </td>
                            <td>{{ number_format($type['count']) }}</td>
                            <td>{{ round(($type['count'] / $stats['total']) * 100, 1) }}%</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="table-card">
                <h3>Language Distribution</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Language</th>
                            <th>Downloads</th>
                            <th>Percentage</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($languageStats as $lang)
                        <tr>
                            <td>
                                <span class="badge badge-success">{{ strtoupper($lang['language']) }}</span>
                            </td>
                            <td>{{ number_format($lang['count']) }}</td>
                            <td>{{ round(($lang['count'] / $stats['total']) * 100, 1) }}%</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Additional Tables -->
        <div class="charts-grid">
            <div class="table-card">
                <h3>Popular WiFi Names</h3>
                <table>
                    <thead>
                        <tr>
                            <th>WiFi Name</th>
                            <th>Downloads</th>
                            <th>Percentage</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($analyticsData['popular_wifi_names'] as $wifi)
                        <tr>
                            <td>{{ $wifi['wifi_ssid'] }}</td>
                            <td>{{ number_format($wifi['count']) }}</td>
                            <td>{{ round(($wifi['count'] / $stats['total']) * 100, 1) }}%</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="table-card">
                <h3>Peak Hours</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Hour</th>
                            <th>Downloads</th>
                            <th>Rank</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($analyticsData['peak_hours'] as $index => $hour)
                        <tr>
                            <td>{{ $hour['hour'] }}</td>
                            <td>{{ number_format($hour['downloads']) }}</td>
                            <td>
                                <span class="badge {{ $index === 0 ? 'badge-primary' : ($index === 1 ? 'badge-success' : 'badge-warning') }}">
                                    #{{ $index + 1 }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        @if(count($countryStats) > 0)
        <div class="table-card">
            <h3>Top Countries</h3>
            <table>
                <thead>
                    <tr>
                        <th>Country</th>
                        <th>Downloads</th>
                        <th>Percentage</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($countryStats as $country)
                    <tr>
                        <td>
                            <span class="badge badge-warning">{{ strtoupper($country['country']) }}</span>
                        </td>
                        <td>{{ number_format($country['count']) }}</td>
                        <td>{{ round(($country['count'] / $stats['total']) * 100, 1) }}%</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif

        <!-- Recent Downloads -->
        @if($stats['total'] > 0)
        <div class="table-card">
            <h3>Recent Downloads (Real Data)</h3>
            <table>
                <thead>
                    <tr>
                        <th>Time</th>
                        <th>WiFi Name</th>
                        <th>Type</th>
                        <th>Features</th>
                        <th>IP Address</th>
                        <th>Language</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach(\App\Models\QrDownload::latest()->limit(10)->get() as $download)
                    <tr>
                        <td>{{ $download->created_at->format('M j, H:i') }}</td>
                        <td>{{ $download->wifi_ssid ?? 'N/A' }}</td>
                        <td>
                            <span class="badge badge-primary">{{ strtoupper($download->download_type) }}</span>
                        </td>
                        <td>
                            @if($download->has_logo)
                                <span class="badge badge-success">Logo</span>
                            @endif
                            @if($download->has_custom_colors)
                                <span class="badge badge-warning">Colors</span>
                            @endif
                            @if(!$download->has_logo && !$download->has_custom_colors)
                                <span style="color: #86868b;">Default</span>
                            @endif
                        </td>
                        <td>{{ $download->ip_address }}</td>
                        <td>{{ strtoupper($download->language) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>

    <script>
        // Daily Chart
        const dailyCtx = document.getElementById('dailyChart').getContext('2d');
        const dailyData = @json($dailyStats);

        new Chart(dailyCtx, {
            type: 'line',
            data: {
                labels: dailyData.map(d => d.date),
                datasets: [{
                    label: 'Downloads',
                    data: dailyData.map(d => d.count),
                    borderColor: '#007aff',
                    backgroundColor: 'rgba(0, 122, 255, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Hourly Chart
        const hourlyCtx = document.getElementById('hourlyChart').getContext('2d');
        const hourlyData = @json($hourlyStats);

        // Fill missing hours with 0
        const hours = Array.from({length: 24}, (_, i) => i);
        const hourlyValues = hours.map(hour => {
            const found = hourlyData.find(d => d.hour == hour);
            return found ? found.count : 0;
        });

        new Chart(hourlyCtx, {
            type: 'bar',
            data: {
                labels: hours.map(h => h + ':00'),
                datasets: [{
                    label: 'Downloads',
                    data: hourlyValues,
                    backgroundColor: '#34c759',
                    borderRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Device Chart
        const deviceCtx = document.getElementById('deviceChart').getContext('2d');
        const deviceData = @json($analyticsData['device_stats']);

        new Chart(deviceCtx, {
            type: 'doughnut',
            data: {
                labels: deviceData.map(d => d.device_type),
                datasets: [{
                    data: deviceData.map(d => d.count),
                    backgroundColor: ['#007aff', '#34c759', '#ff9500'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });

        // Referrer Chart
        const referrerCtx = document.getElementById('referrerChart').getContext('2d');
        const referrerData = @json($analyticsData['referrer_stats']);

        new Chart(referrerCtx, {
            type: 'pie',
            data: {
                labels: referrerData.map(d => d.referrer_type),
                datasets: [{
                    data: referrerData.map(d => d.count),
                    backgroundColor: ['#007aff', '#34c759', '#ff9500', '#ff3b30', '#af52de', '#ff2d92'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });

        // Custom date range function
        async function loadCustomStats() {
            const startDate = document.getElementById('start-date').value;
            const endDate = document.getElementById('end-date').value;

            try {
                const response = await fetch(`/admin/stats-range?start_date=${startDate}&end_date=${endDate}`);
                const data = await response.json();

                document.getElementById('custom-stats').innerHTML = `
                    <div style="display: flex; gap: 20px;">
                        <div><strong>Downloads:</strong> ${data.downloads.toLocaleString()}</div>
                        <div><strong>Unique Users:</strong> ${data.unique_users.toLocaleString()}</div>
                        <div><strong>Avg per User:</strong> ${data.avg_per_user}</div>
                    </div>
                `;
                document.getElementById('custom-stats').style.display = 'block';
            } catch (error) {
                console.error('Error loading custom stats:', error);
            }
        }

        // Export data function
        function exportData() {
            const startDate = document.getElementById('start-date').value;
            const endDate = document.getElementById('end-date').value;

            const url = `/admin/export-csv?start_date=${startDate}&end_date=${endDate}`;
            window.open(url, '_blank');
        }
    </script>
</body>
</html>

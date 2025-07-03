<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\QrDownload;
use Carbon\Carbon;

class QrDownloadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $languages = ['en', 'vi', 'zh', 'ko', 'ja', 'es', 'id', 'fr', 'de', 'hi'];
        $downloadTypes = ['png', 'pdf'];
        $countries = ['US', 'VN', 'CN', 'KR', 'JP', 'ES', 'ID', 'FR', 'DE', 'IN'];
        $wifiNames = ['CafeWiFi', 'Hotel_Guest', 'Office_WiFi', 'Restaurant_Free', 'Home_Network'];

        // Generate data for the last 30 days
        for ($day = 30; $day >= 0; $day--) {
            $date = Carbon::now()->subDays($day);

            // Generate 10-50 downloads per day
            $downloadsPerDay = rand(10, 50);

            for ($i = 0; $i < $downloadsPerDay; $i++) {
                // Random time during the day
                $randomTime = $date->copy()->addHours(rand(0, 23))->addMinutes(rand(0, 59));

                QrDownload::create([
                    'session_id' => 'session_' . rand(1000, 9999) . '_' . $day . '_' . $i,
                    'ip_address' => $this->generateRandomIP(),
                    'user_agent' => $this->generateRandomUserAgent(),
                    'download_type' => $downloadTypes[array_rand($downloadTypes)],
                    'wifi_ssid' => $wifiNames[array_rand($wifiNames)],
                    'has_logo' => rand(0, 1),
                    'has_custom_colors' => rand(0, 1),
                    'language' => $languages[array_rand($languages)],
                    'country' => $countries[array_rand($countries)],
                    'referrer' => rand(0, 1) ? 'https://google.com' : null,
                    'created_at' => $randomTime,
                    'updated_at' => $randomTime
                ]);
            }
        }
    }

    private function generateRandomIP(): string
    {
        return rand(1, 255) . '.' . rand(1, 255) . '.' . rand(1, 255) . '.' . rand(1, 255);
    }

    private function generateRandomUserAgent(): string
    {
        $userAgents = [
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36',
            'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36',
            'Mozilla/5.0 (iPhone; CPU iPhone OS 14_6 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.0 Mobile/15E148 Safari/604.1',
            'Mozilla/5.0 (Android 11; Mobile; rv:89.0) Gecko/89.0 Firefox/89.0'
        ];

        return $userAgents[array_rand($userAgents)];
    }
}

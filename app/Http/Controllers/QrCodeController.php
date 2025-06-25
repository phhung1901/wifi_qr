<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class QrCodeController extends Controller
{
    public function index()
    {
        return view('qrcode.index');
    }

    public function generate(Request $request)
    {
        $validated = $request->validate([
            'ssid' => 'required|string|max:255',
            'password' => 'nullable|string|max:255',
            'encryption' => 'required|in:WPA,WEP,nopass',
            'customization' => 'nullable|array',
            'customization.foregroundColor' => 'nullable|string|regex:/^#[0-9a-fA-F]{6}$/',
            'customization.backgroundColor' => 'nullable|string|regex:/^#[0-9a-fA-F]{6}$/',
            'customization.size' => 'nullable|integer|min:128|max:1024',
            'customization.margin' => 'nullable|integer|min:0|max:10',
            'customization.logoSize' => 'nullable|numeric|min:0.1|max:0.5',
            'customization.cornerRadius' => 'nullable|integer|min:0|max:50',
        ]);

        $ssid = $validated['ssid'];
        $password = $validated['password'] ?? '';
        $encryption = $validated['encryption'];
        $customization = $validated['customization'] ?? [];

        // Format WiFi QR code content
        $wifiString = "WIFI:T:{$encryption};S:{$ssid};P:{$password};;";

        return response()->json([
            'wifiString' => $wifiString,
            'customization' => $customization,
            'wifiInfo' => [
                'ssid' => $ssid,
                'encryption' => $encryption,
                'hasPassword' => !empty($password)
            ]
        ]);
    }

    public function generatePoster(Request $request)
    {
        $validated = $request->validate([
            'ssid' => 'required|string|max:255',
            'template' => 'required|in:simple,cafe,hotel,office,home',
            'size' => 'required|in:a4,a5,card,square',
            'customization' => 'nullable|array',
        ]);

        // This endpoint will be used by the frontend to get poster configuration
        return response()->json([
            'success' => true,
            'config' => $validated
        ]);
    }
}
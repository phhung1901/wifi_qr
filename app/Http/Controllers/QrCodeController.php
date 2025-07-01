<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class QrCodeController extends Controller
{
    public function index()
    {
        return view('wifi-qr', [
            'pageType' => 'general',
            'title' => 'Free WiFi QR Code Generator - Create Custom QR Codes with Logo',
            'description' => 'Create beautiful WiFi QR codes instantly! Free generator with custom logos, colors, and real-time preview. Perfect for restaurants, hotels, and offices.',
            'keywords' => 'wifi qr code generator, free wifi qr code, qr code for wifi, wifi password qr code, custom wifi qr'
        ]);
    }

    public function restaurant()
    {
        return view('wifi-qr', [
            'pageType' => 'restaurant',
            'title' => 'Restaurant WiFi QR Code Generator - Free Custom QR Codes for Restaurants',
            'description' => 'Create professional WiFi QR codes for your restaurant. Add your logo, customize colors, and provide instant WiFi access to customers. Free and easy to use.',
            'keywords' => 'restaurant wifi qr code, cafe wifi qr, restaurant qr code generator, dining wifi access, table wifi qr'
        ]);
    }

    public function hotel()
    {
        return view('wifi-qr', [
            'pageType' => 'hotel',
            'title' => 'Hotel WiFi QR Code Generator - Guest WiFi Access Made Easy',
            'description' => 'Generate professional WiFi QR codes for hotels and accommodations. Provide seamless WiFi access to guests with custom branded QR codes.',
            'keywords' => 'hotel wifi qr code, guest wifi qr, accommodation wifi access, hotel qr generator, hospitality wifi'
        ]);
    }

    public function office()
    {
        return view('wifi-qr', [
            'pageType' => 'office',
            'title' => 'Office WiFi QR Code Generator - Professional Guest WiFi Access',
            'description' => 'Create secure WiFi QR codes for offices and coworking spaces. Professional guest WiFi access with custom branding and easy setup.',
            'keywords' => 'office wifi qr code, business wifi qr, coworking wifi access, professional wifi qr, guest wifi office'
        ]);
    }

    public function blog()
    {
        return view('blog');
    }
}

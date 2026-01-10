<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SaasSetting;
use App\Models\SubscriptionPackage;

class SitemapController extends Controller
{
    public function index()
    {
        $baseUrl = config('app.url');
        
        // Static Routes with Priority
        $pages = [
            ['url' => route('home'), 'priority' => '1.0', 'changefreq' => 'daily'],
            ['url' => route('landing.features'), 'priority' => '0.8', 'changefreq' => 'weekly'],
            ['url' => route('landing.pricing'), 'priority' => '0.8', 'changefreq' => 'weekly'],
            ['url' => route('landing.testimonials'), 'priority' => '0.6', 'changefreq' => 'monthly'],
            ['url' => route('landing.faq'), 'priority' => '0.6', 'changefreq' => 'monthly'],
            ['url' => route('landing.privacy'), 'priority' => '0.5', 'changefreq' => 'yearly'],
            ['url' => route('landing.terms'), 'priority' => '0.5', 'changefreq' => 'yearly'],
            ['url' => route('login'), 'priority' => '0.5', 'changefreq' => 'monthly'],
            ['url' => route('register'), 'priority' => '0.7', 'changefreq' => 'monthly'],
        ];

        // determine latest valid date for static pages (from settings update)
        $latestUpdate = SaasSetting::latest('updated_at')->value('updated_at');
        $lastMod = $latestUpdate ? $latestUpdate->toAtomString() : now()->toAtomString();
        $xmlHeader = '<?xml version="1.0" encoding="UTF-8"?>';

        return response()->view('sitemap.index', compact('pages', 'lastMod', 'xmlHeader'))
            ->header('Content-Type', 'text/xml');
    }
}

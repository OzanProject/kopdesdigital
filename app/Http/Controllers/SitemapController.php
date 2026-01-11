<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SaasSetting;
use App\Models\Article; // Tambahkan model Article
use Carbon\Carbon;

class SitemapController extends Controller
{
    public function index()
    {
        // 1. Static Routes (Halaman Utama)
        $pages = [
            ['url' => route('home'), 'priority' => '1.0', 'changefreq' => 'daily'],
            ['url' => route('landing.features'), 'priority' => '0.8', 'changefreq' => 'weekly'],
            ['url' => route('landing.pricing'), 'priority' => '0.8', 'changefreq' => 'weekly'],
            ['url' => route('landing.testimonials'), 'priority' => '0.6', 'changefreq' => 'monthly'],
            ['url' => route('landing.faq'), 'priority' => '0.6', 'changefreq' => 'monthly'],
            ['url' => route('landing.privacy'), 'priority' => '0.5', 'changefreq' => 'yearly'],
            ['url' => route('landing.terms'), 'priority' => '0.5', 'changefreq' => 'yearly'],
            ['url' => route('login'), 'priority' => '0.4', 'changefreq' => 'monthly'],
            ['url' => route('register'), 'priority' => '0.7', 'changefreq' => 'monthly'],
        ];

        // 2. Dynamic Routes (Artikel Knowledge Base)
        // Kita ambil semua artikel yang sudah dipublish
        $articles = Article::where('is_published', true)->latest('updated_at')->get();
        
        foreach ($articles as $article) {
            $pages[] = [
                'url' => route('knowledge-base.show', $article->slug),
                'priority' => '0.7',
                'changefreq' => 'weekly',
                'lastmod' => $article->updated_at->toAtomString() // Tanggal spesifik artikel
            ];
        }

        // 3. Tentukan tanggal modifikasi terbaru secara global
        $latestSetting = SaasSetting::latest('updated_at')->value('updated_at');
        $latestArticle = Article::where('is_published', true)->latest('updated_at')->value('updated_at');
        
        // Pilih mana yang lebih baru antara setting saas atau artikel terakhir
        $newestDate = max($latestSetting, $latestArticle);
        $lastMod = $newestDate ? Carbon::parse($newestDate)->toAtomString() : now()->toAtomString();
        
        $xmlHeader = '<?xml version="1.0" encoding="UTF-8"?>';

        // Pastikan view path sesuai (sitemap.index atau sitemap)
        return response()->view('sitemap.index', compact('pages', 'lastMod', 'xmlHeader'))
            ->header('Content-Type', 'text/xml');
    }
}
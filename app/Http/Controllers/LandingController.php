<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        $settings = \App\Models\SaasSetting::all()->pluck('value', 'key');
        $features = \App\Models\LandingFeature::orderBy('order', 'asc')->get();
        $faqs = \App\Models\LandingFaq::orderBy('order', 'asc')->get();
        $testimonials = \App\Models\LandingTestimonial::latest()->get();
        $packages = \App\Models\SubscriptionPackage::where('is_active', true)->get();
        // Get active discounts for public display
        $availableDiscounts = \App\Models\Discount::where('is_active', true)
            ->where(function($q) {
                $q->whereNull('valid_until')->orWhere('valid_until', '>=', now());
            })
            ->where(function($q) {
                $q->whereNull('max_uses')->orWhereColumn('used_count', '<', 'max_uses');
            })
            ->latest()
            ->get();

        return view('landing.index', compact('settings', 'features', 'faqs', 'testimonials', 'packages', 'availableDiscounts'));
    }

    public function features()
    {
        $settings = \App\Models\SaasSetting::all()->pluck('value', 'key');
        $features = \App\Models\LandingFeature::orderBy('order', 'asc')->get();
        return view('landing.pages.features', compact('settings', 'features'));
    }

    public function pricing()
    {
        $settings = \App\Models\SaasSetting::all()->pluck('value', 'key');
        $packages = \App\Models\SubscriptionPackage::where('is_active', true)->get();
        $availableDiscounts = \App\Models\Discount::where('is_active', true)
            ->where(function($q) {
                $q->whereNull('valid_until')->orWhere('valid_until', '>=', now());
            })
            ->where(function($q) {
                $q->whereNull('max_uses')->orWhereColumn('used_count', '<', 'max_uses');
            })
            ->latest()
            ->get();
        
        $faqs = \App\Models\LandingFaq::orderBy('order', 'asc')->get();

        return view('landing.pages.pricing', compact('settings', 'packages', 'availableDiscounts', 'faqs'));
    }

    public function testimonials()
    {
        $settings = \App\Models\SaasSetting::all()->pluck('value', 'key');
        $testimonials = \App\Models\LandingTestimonial::latest()->get();
        return view('landing.pages.testimonials', compact('settings', 'testimonials'));
    }

    public function faq()
    {
        $settings = \App\Models\SaasSetting::all()->pluck('value', 'key');
        $faqs = \App\Models\LandingFaq::orderBy('order', 'asc')->get();
        return view('landing.pages.faq', compact('settings', 'faqs'));
    }

    public function privacy()
    {
        $settings = \App\Models\SaasSetting::all()->pluck('value', 'key');
        return view('landing.pages.privacy', compact('settings'));
    }

    public function terms()
    {
        $settings = \App\Models\SaasSetting::all()->pluck('value', 'key');
        return view('landing.pages.terms', compact('settings'));
    }
}

<?php

namespace App\Http\Controllers\SaaS;

use App\Http\Controllers\Controller;
use App\Models\LandingFeature;
use Illuminate\Http\Request;

class LandingFeatureController extends Controller
{
    public function index()
    {
        $features = LandingFeature::orderBy('order', 'asc')->get();
        return view('saas.landing.features.index', compact('features'));
    }

    public function create()
    {
        return view('saas.landing.features.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'order' => 'numeric',
            'icon' => 'nullable'
        ]);

        LandingFeature::create($request->all());

        return redirect()->route('landing-features.index')->with('success', 'Fitur berhasil ditambahkan.');
    }

    public function edit(LandingFeature $landingFeature)
    {
        return view('saas.landing.features.edit', compact('landingFeature'));
    }

    public function update(Request $request, LandingFeature $landingFeature)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'order' => 'numeric',
            'icon' => 'nullable'
        ]);

        $landingFeature->update($request->all());

        return redirect()->route('landing-features.index')->with('success', 'Fitur berhasil diperbarui.');
    }

    public function destroy(LandingFeature $landingFeature)
    {
        $landingFeature->delete();
        return redirect()->route('landing-features.index')->with('success', 'Fitur berhasil dihapus.');
    }
}

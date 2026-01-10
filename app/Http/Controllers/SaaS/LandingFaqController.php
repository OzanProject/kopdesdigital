<?php

namespace App\Http\Controllers\SaaS;

use App\Http\Controllers\Controller;
use App\Models\LandingFaq;
use Illuminate\Http\Request;

class LandingFaqController extends Controller
{
    public function index()
    {
        $faqs = LandingFaq::orderBy('order', 'asc')->get();
        return view('saas.landing.faqs.index', compact('faqs'));
    }

    public function create()
    {
        return view('saas.landing.faqs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required',
            'answer' => 'required',
            'order' => 'numeric'
        ]);

        LandingFaq::create($request->all());

        return redirect()->route('landing-faqs.index')->with('success', 'FAQ berhasil ditambahkan.');
    }

    public function edit(LandingFaq $landingFaq)
    {
        return view('saas.landing.faqs.edit', compact('landingFaq'));
    }

    public function update(Request $request, LandingFaq $landingFaq)
    {
        $request->validate([
            'question' => 'required',
            'answer' => 'required',
            'order' => 'numeric'
        ]);

        $landingFaq->update($request->all());

        return redirect()->route('landing-faqs.index')->with('success', 'FAQ berhasil diperbarui.');
    }

    public function destroy(LandingFaq $landingFaq)
    {
        $landingFaq->delete();
        return redirect()->route('landing-faqs.index')->with('success', 'FAQ berhasil dihapus.');
    }
}

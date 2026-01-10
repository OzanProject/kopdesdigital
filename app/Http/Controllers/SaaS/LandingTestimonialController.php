<?php

namespace App\Http\Controllers\SaaS;

use App\Http\Controllers\Controller;
use App\Models\LandingTestimonial;
use Illuminate\Http\Request;

class LandingTestimonialController extends Controller
{
    public function index()
    {
        $testimonials = LandingTestimonial::latest()->get();
        return view('saas.landing.testimonials.index', compact('testimonials'));
    }

    public function create()
    {
        return view('saas.landing.testimonials.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'role' => 'nullable',
            'content' => 'required',
            'rating' => 'required|numeric|min:1|max:5',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->all();

        if ($request->hasFile('avatar')) {
            $data['avatar'] = $request->file('avatar')->store('testimonials', 'public');
        }

        LandingTestimonial::create($data);

        return redirect()->route('landing-testimonials.index')->with('success', 'Testimoni berhasil ditambahkan.');
    }

    public function edit(LandingTestimonial $landingTestimonial)
    {
        return view('saas.landing.testimonials.edit', compact('landingTestimonial'));
    }

    public function update(Request $request, LandingTestimonial $landingTestimonial)
    {
        $request->validate([
            'name' => 'required',
            'role' => 'nullable',
            'content' => 'required',
            'rating' => 'required|numeric|min:1|max:5',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->all();

        if ($request->hasFile('avatar')) {
             if ($landingTestimonial->avatar && \Storage::disk('public')->exists($landingTestimonial->avatar)) {
                \Storage::disk('public')->delete($landingTestimonial->avatar);
            }
            $data['avatar'] = $request->file('avatar')->store('testimonials', 'public');
        }

        $landingTestimonial->update($data);

        return redirect()->route('landing-testimonials.index')->with('success', 'Testimoni berhasil diperbarui.');
    }

    public function destroy(LandingTestimonial $landingTestimonial)
    {
        if ($landingTestimonial->avatar && \Storage::disk('public')->exists($landingTestimonial->avatar)) {
            \Storage::disk('public')->delete($landingTestimonial->avatar);
        }
        $landingTestimonial->delete();
        return redirect()->route('landing-testimonials.index')->with('success', 'Testimoni berhasil dihapus.');
    }
}

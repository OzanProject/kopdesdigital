<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [\App\Http\Controllers\LandingController::class, 'index'])->name('home');
Route::get('/features', [\App\Http\Controllers\LandingController::class, 'features'])->name('landing.features');
Route::get('/pricing', [\App\Http\Controllers\LandingController::class, 'pricing'])->name('landing.pricing');
Route::get('/testimonials', [\App\Http\Controllers\LandingController::class, 'testimonials'])->name('landing.testimonials');
Route::get('/faq', [\App\Http\Controllers\LandingController::class, 'faq'])->name('landing.faq');
Route::get('/privacy-policy', [\App\Http\Controllers\LandingController::class, 'privacy'])->name('landing.privacy');
Route::get('/terms-of-service', [\App\Http\Controllers\LandingController::class, 'terms'])->name('landing.terms');
Route::get('/sitemap.xml', [\App\Http\Controllers\SitemapController::class, 'index'])->name('sitemap');

// Dashboard and other admin routes are now in routes/admin.php

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Payment Routes
Route::middleware('auth')->group(function() {
    Route::get('/payment/success', [\App\Http\Controllers\PaymentController::class, 'success'])->name('payment.success');
    Route::post('/payment/{order_id}/renew', [\App\Http\Controllers\PaymentController::class, 'renew'])->name('payment.renew');
    Route::get('/payment/{order_id}', [\App\Http\Controllers\PaymentController::class, 'show'])->name('payment.show');
});

Route::post('/midtrans/callback', [\App\Http\Controllers\PaymentController::class, 'callback'])->name('midtrans.callback'); // Exclude from CSRF later

require __DIR__.'/auth.php';

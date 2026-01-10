<?php

use App\Http\Controllers\SaaS\DashboardController;
use App\Http\Controllers\SaaS\NasabahController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified', 'tenant'])->group(function () { // Group middleware
    
    // Tenant Routes (Prefix: /admin)
    Route::group(['prefix' => 'admin', 'middleware' => ['subscription_active']], function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::get('nasabah/template', [NasabahController::class, 'template'])->name('nasabah.template');
        Route::post('nasabah/import', [NasabahController::class, 'import'])->name('nasabah.import');
        Route::post('nasabah/print-cards', [NasabahController::class, 'bulkPrint'])->name('nasabah.print_cards');
        Route::delete('nasabah/bulk-destroy', [NasabahController::class, 'bulkDestroy'])->name('nasabah.bulk_destroy');
        Route::resource('nasabah', NasabahController::class);
        Route::resource('simpanan', \App\Http\Controllers\SaaS\SimpananController::class);
        Route::resource('pinjaman', \App\Http\Controllers\SaaS\PinjamanController::class);
        Route::resource('penarikan', \App\Http\Controllers\SaaS\PenarikanController::class);
        
        // Laporan Routes
        Route::get('/laporan', [\App\Http\Controllers\SaaS\LaporanController::class, 'index'])->name('laporan.index');
        
        // SHU Management
        Route::resource('shu', \App\Http\Controllers\SaaS\ShuController::class);
        Route::post('shu/{shu}/publish', [\App\Http\Controllers\SaaS\ShuController::class, 'publish'])->name('shu.publish');
        Route::get('/laporan/print', [\App\Http\Controllers\SaaS\LaporanController::class, 'print'])->name('laporan.print');
        
        // User Management
        Route::resource('users', \App\Http\Controllers\SaaS\UserController::class);
        
        // Settings
        Route::get('/setting', [\App\Http\Controllers\SaaS\SettingController::class, 'index'])->name('setting.index');
        Route::put('/setting', [\App\Http\Controllers\SaaS\SettingController::class, 'update'])->name('setting.update');

        // Profile (Custom)
        // Profile (Custom)
        Route::get('/profile', [\App\Http\Controllers\SaaS\ProfileController::class, 'edit'])->name('admin.profile.edit');
        Route::put('/profile', [\App\Http\Controllers\SaaS\ProfileController::class, 'update'])->name('admin.profile.update');

        // Subscription Management
        Route::get('/subscription', [\App\Http\Controllers\SaaS\SubscriptionController::class, 'index'])->name('subscription.index');
        Route::post('/subscription/upgrade', [\App\Http\Controllers\SaaS\SubscriptionController::class, 'upgrade'])->name('subscription.upgrade');
        Route::post('/subscription/check-coupon', [\App\Http\Controllers\SaaS\SubscriptionController::class, 'checkCoupon'])->name('subscription.check-coupon');
        Route::delete('/subscription/transaction/{id}', [\App\Http\Controllers\SaaS\SubscriptionController::class, 'destroyTransaction'])->name('subscription.transaction.destroy');

        // Manual route preferred to avoid full resource clutter if not needed
        Route::get('angsuran/{angsuran}/pay', [\App\Http\Controllers\SaaS\AngsuranController::class, 'edit'])->name('angsuran.edit');
        Route::put('angsuran/{angsuran}', [\App\Http\Controllers\SaaS\AngsuranController::class, 'update'])->name('angsuran.update');
        // Support System
        Route::get('/support', [\App\Http\Controllers\SaaS\SupportTicketController::class, 'index'])->name('support.index');
        Route::get('/support/create', [\App\Http\Controllers\SaaS\SupportTicketController::class, 'create'])->name('support.create');
        Route::post('/support', [\App\Http\Controllers\SaaS\SupportTicketController::class, 'store'])->name('support.store');
        Route::get('/support/{id}', [\App\Http\Controllers\SaaS\SupportTicketController::class, 'show'])->name('support.show');
        Route::post('/support/{id}/reply', [\App\Http\Controllers\SaaS\SupportTicketController::class, 'reply'])->name('support.reply');
        Route::delete('/support/{id}', [\App\Http\Controllers\SaaS\SupportTicketController::class, 'destroy'])->name('support.destroy');

        // Knowledge Base (Pusat Bantuan)
        Route::get('/knowledge-base', [\App\Http\Controllers\SaaS\KnowledgeBaseController::class, 'index'])->name('knowledge-base.index');
        
        // Manual Payment Check
        Route::get('/payment/check/{order_id}', [\App\Http\Controllers\PaymentController::class, 'checkStatus'])->name('payment.check');

        Route::get('/knowledge-base/search', [\App\Http\Controllers\SaaS\KnowledgeBaseController::class, 'search'])->name('knowledge-base.search');
        Route::get('/knowledge-base/category/{slug}', [\App\Http\Controllers\SaaS\KnowledgeBaseController::class, 'category'])->name('knowledge-base.category');
        Route::get('/knowledge-base/article/{slug}', [\App\Http\Controllers\SaaS\KnowledgeBaseController::class, 'show'])->name('knowledge-base.show');
    });

    // Safe Place for Super Admin Routes
    Route::group(['middleware' => ['role:super_admin'], 'prefix' => 'super-admin'], function () {
        Route::get('/dashboard', [\App\Http\Controllers\SaaS\DashboardController::class, 'superAdmin'])->name('super.dashboard');
        
        // Profile
        Route::get('/profile', [\App\Http\Controllers\SaaS\ProfileController::class, 'edit'])->name('super.profile.edit');
        Route::put('/profile', [\App\Http\Controllers\SaaS\ProfileController::class, 'update'])->name('super.profile.update');
        
        Route::resource('koperasi', \App\Http\Controllers\SaaS\KoperasiController::class);
        Route::post('koperasi/{koperasi}/reset', [\App\Http\Controllers\SaaS\KoperasiController::class, 'resetData'])->name('koperasi.reset');
        Route::resource('koperasi.users', \App\Http\Controllers\SaaS\KoperasiUserController::class);
        Route::resource('subscription-packages', \App\Http\Controllers\SaaS\SubscriptionPackageController::class);
        
        Route::get('/users', [\App\Http\Controllers\SaaS\GlobalUserController::class, 'index'])->name('global-users.index');
        
        // Discount Management
        Route::resource('discounts', \App\Http\Controllers\SaaS\DiscountController::class);

        // Global Settings
        Route::get('/settings', [\App\Http\Controllers\SaaS\SaasSettingController::class, 'index'])->name('saas-settings.index');
        Route::put('/settings/{id}', [\App\Http\Controllers\SaaS\SaasSettingController::class, 'update'])->name('saas-settings.update');

        // Invoice/Transaction Management
        Route::get('/invoices', [\App\Http\Controllers\SaaS\InvoiceController::class, 'index'])->name('invoices.index');
        Route::get('/invoices/{id}', [\App\Http\Controllers\SaaS\InvoiceController::class, 'show'])->name('invoices.show');
        Route::post('/invoices/{id}/approve', [\App\Http\Controllers\SaaS\InvoiceController::class, 'approve'])->name('invoices.approve');


        // Landing Page CMS
        Route::get('/landing-settings', [\App\Http\Controllers\SaaS\LandingSettingController::class, 'index'])->name('landing-settings.index');
        Route::put('/landing-settings', [\App\Http\Controllers\SaaS\LandingSettingController::class, 'update'])->name('landing-settings.update');
        Route::post('/landing-settings/test-email', [\App\Http\Controllers\SaaS\LandingSettingController::class, 'testEmail'])->name('landing-settings.test-email');
        Route::post('/landing-settings/clear-cache', [\App\Http\Controllers\SaaS\LandingSettingController::class, 'clearCache'])->name('landing-settings.clear-cache');
        Route::post('/landing-settings/fix-storage', [\App\Http\Controllers\SaaS\LandingSettingController::class, 'fixStorageLink'])->name('landing-settings.fix-storage');



        Route::resource('landing-features', \App\Http\Controllers\SaaS\LandingFeatureController::class);
        Route::resource('landing-faqs', \App\Http\Controllers\SaaS\LandingFaqController::class);
        Route::resource('landing-testimonials', \App\Http\Controllers\SaaS\LandingTestimonialController::class);
        // Support Management
        Route::resource('support-tickets', \App\Http\Controllers\Admin\SupportTicketController::class);
        Route::post('support-tickets/{id}/reply', [\App\Http\Controllers\Admin\SupportTicketController::class, 'reply'])->name('admin.support.reply');
        Route::post('support-tickets/{id}/close', [\App\Http\Controllers\Admin\SupportTicketController::class, 'close'])->name('admin.support.close');
        
        // Backups
        Route::get('/backups', [\App\Http\Controllers\Admin\BackupController::class, 'index'])->name('backups.index');
        Route::post('/backups', [\App\Http\Controllers\Admin\BackupController::class, 'create'])->name('backups.create');
        Route::get('/backups/{file_name}', [\App\Http\Controllers\Admin\BackupController::class, 'download'])->name('backups.download');
        Route::delete('/backups/{file_name}', [\App\Http\Controllers\Admin\BackupController::class, 'destroy'])->name('backups.destroy');
        Route::post('/backups/{file_name}/restore', [\App\Http\Controllers\Admin\BackupController::class, 'restore'])->name('backups.restore');

        // Knowledge Base
        Route::resource('article-categories', \App\Http\Controllers\Admin\ArticleCategoryController::class, ['as' => 'admin']);
        Route::resource('articles', \App\Http\Controllers\Admin\ArticleController::class, ['as' => 'admin']);
    });

    // Member Routes
    Route::group(['middleware' => ['role:member'], 'prefix' => 'member', 'as' => 'member.'], function () {
        Route::get('/dashboard', [\App\Http\Controllers\Member\DashboardController::class, 'index'])->name('dashboard');
        
        // Profile
        Route::get('/profile', [\App\Http\Controllers\Member\ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [\App\Http\Controllers\Member\ProfileController::class, 'update'])->name('profile.update');
        Route::get('/profile/card', [\App\Http\Controllers\Member\ProfileController::class, 'printCard'])->name('profile.card');
        // Features
        Route::get('/simpanan', [\App\Http\Controllers\Member\SimpananController::class, 'index'])->name('simpanan.index');
        Route::get('/pinjaman', [\App\Http\Controllers\Member\PinjamanController::class, 'index'])->name('pinjaman.index');
        Route::get('/pinjaman/create', [\App\Http\Controllers\Member\PinjamanController::class, 'create'])->name('pinjaman.create');
        Route::post('/pinjaman', [\App\Http\Controllers\Member\PinjamanController::class, 'store'])->name('pinjaman.store');
        Route::get('/shu', [\App\Http\Controllers\Member\ShuController::class, 'index'])->name('shu.index');
    });

    // Future routes for Simpanan, Pinjaman, etc.
});

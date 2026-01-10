<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('subscription_transactions', function (Blueprint $table) {
            if (!Schema::hasColumn('subscription_transactions', 'notes')) {
                $table->text('notes')->nullable()->after('status');
            }
            if (!Schema::hasColumn('subscription_transactions', 'payment_type')) {
                $table->string('payment_type')->nullable()->after('notes');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subscription_transactions', function (Blueprint $table) {
            if (Schema::hasColumn('subscription_transactions', 'notes')) {
                $table->dropColumn('notes');
            }
            if (Schema::hasColumn('subscription_transactions', 'payment_type')) {
                $table->dropColumn('payment_type');
            }
        });
    }
};

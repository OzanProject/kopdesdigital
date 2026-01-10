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
        Schema::table('koperasis', function (Blueprint $table) {
            $table->foreignId('subscription_package_id')->nullable()->after('status')->constrained('subscription_packages')->nullOnDelete();
            $table->dropColumn('paket_langganan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('koperasis', function (Blueprint $table) {
            $table->dropForeign(['subscription_package_id']);
            $table->dropColumn('subscription_package_id');
            $table->string('paket_langganan')->nullable();
        });
    }
};

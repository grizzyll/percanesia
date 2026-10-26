<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('email')->nullable()->after('recipient_name');
            $table->string('country', 60)->default('Indonesia')->after('city');
            $table->string('shipping_method', 30)->nullable()->after('shipping_cost');
            $table->string('shipping_label', 100)->nullable()->after('shipping_method');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['email', 'country', 'shipping_method', 'shipping_label']);
        });
    }
};

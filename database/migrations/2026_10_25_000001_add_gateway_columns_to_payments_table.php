<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->string('channel', 30)->nullable()->after('method');          // bca, ovo, card, swift, dst
            $table->unsignedSmallInteger('attempt')->default(0)->after('channel'); // percobaan ke-berapa (order_id Midtrans = nomor-order-attempt)
            $table->string('gateway_order_id', 80)->nullable()->index()->after('attempt');
            $table->string('snap_token')->nullable()->after('gateway_order_id');
            $table->string('gateway_payment_type', 50)->nullable()->after('snap_token');
            $table->string('gateway_transaction_id', 100)->nullable()->after('gateway_payment_type');
            $table->text('payment_info')->nullable()->after('gateway_transaction_id'); // JSON: nomor VA dll
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn([
                'channel', 'attempt', 'gateway_order_id', 'snap_token',
                'gateway_payment_type', 'gateway_transaction_id', 'payment_info',
            ]);
        });
    }
};

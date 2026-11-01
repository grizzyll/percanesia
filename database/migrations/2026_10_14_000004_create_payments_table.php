<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->string('method', 20);            // kunci dari config/shop.php: bca, bri, qris, dana
            $table->unsignedInteger('amount');
            // pending, menunggu_verifikasi, berhasil, ditolak, kedaluwarsa
            $table->string('status', 30)->default('pending');
            $table->string('proof_path')->nullable(); // bukti transfer
            $table->timestamp('expires_at')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};

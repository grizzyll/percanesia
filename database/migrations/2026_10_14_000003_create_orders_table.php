<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // penerima
            $table->string('recipient_name');
            $table->string('phone', 20);
            $table->text('address');
            $table->string('city');
            $table->string('postal_code', 10);
            $table->text('note')->nullable();

            // nominal (rupiah)
            $table->unsignedInteger('subtotal');
            $table->unsignedInteger('shipping_cost');
            $table->unsignedInteger('total');

            // menunggu_pembayaran, menunggu_verifikasi, dibayar, dikirim, selesai, dibatalkan
            $table->string('status', 30)->default('menunggu_pembayaran');
            $table->timestamps();
        });

        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->nullable()->constrained()->nullOnDelete();

            // disalin saat checkout supaya data order tidak berubah kalau produk diedit
            $table->string('product_name');
            $table->string('variant')->nullable();
            $table->unsignedInteger('price');
            $table->unsignedSmallInteger('quantity');
            $table->unsignedInteger('subtotal');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
    }
};

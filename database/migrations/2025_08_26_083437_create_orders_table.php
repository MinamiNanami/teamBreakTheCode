<?php

// database/migrations/xxxx_create_orders_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name')->default('Guest');
            $table->string('table_number')->nullable();
            $table->enum('order_method', ['dine-in','take-out','kiosk'])->default('kiosk');
            $table->enum('payment_method', ['cash','token'])->default('cash');
            $table->decimal('total_price',10,2)->default(0);
            $table->json('cart')->nullable();
            $table->timestamps();
        });

        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->string('item_name');
            $table->decimal('price',10,2);
            $table->integer('quantity');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
    }
};


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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->enum('status', ['pending', 'processing', 'completed', 'declined', 'canceled'])->default('pending');
            $table->decimal('total', 12, 2);
            $table->enum('payment_method', ['online', 'cash_on_delivery']);
            $table->json('items'); 
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};

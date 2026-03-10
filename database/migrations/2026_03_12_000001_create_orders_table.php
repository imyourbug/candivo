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
            $table->string('order_number', 64)->unique()->comment('Human-readable order reference');
            $table->string('email')->nullable();
            $table->string('customer_name')->nullable();
            $table->text('address')->nullable()->comment('Shipping/licensing address (JSON or plain)');
            $table->decimal('subtotal', 12, 2)->default(0);
            $table->decimal('discount', 12, 2)->default(0);
            $table->decimal('tax', 12, 2)->default(0);
            $table->decimal('total', 12, 2);
            $table->string('currency', 3)->default('USD');
            $table->string('payment_method', 32)->nullable()->comment('paypal, mollie, etc.');
            $table->string('payment_gateway_id', 255)->nullable()->comment('External payment id (PayPal/Mollie)');
            $table->string('status', 32)->default('pending')->comment('pending, completed, failed, cancelled, refunded');
            $table->timestamp('paid_at')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};

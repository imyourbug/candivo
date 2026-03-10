<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
            $table->string('entity_type', 32)->comment('product or package');
            $table->unsignedBigInteger('entity_id')->comment('product.id or package.id');
            $table->string('name')->comment('Snapshot of product/package name at order time');
            $table->unsignedInteger('duration_months')->nullable()->comment('e.g. 12 for 12-month license');
            $table->string('period_label', 64)->nullable()->comment('e.g. "12 months" for display');
            $table->unsignedInteger('quantity')->default(1);
            $table->decimal('unit_price', 10, 2);
            $table->decimal('total_price', 12, 2);
            $table->string('currency', 3)->default('USD');
            $table->json('metadata')->nullable()->comment('Extra snapshot data (slug, image, etc.)');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};

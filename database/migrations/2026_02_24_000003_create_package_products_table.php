<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('package_products', function (Blueprint $table) {
            $table->foreignId('package_id')->constrained('packages');
            $table->foreignId('product_id')->constrained('products');
            $table->primary(['package_id', 'product_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('package_products');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pricings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('entity_id');
            $table->enum('entity_type', ['product', 'package']);
            $table->integer('duration_months');
            $table->decimal('price', 10, 2);
            $table->string('currency')->default('USD');
            $table->unique(['entity_id', 'entity_type', 'duration_months'], 'unique_price');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pricings');
    }
};

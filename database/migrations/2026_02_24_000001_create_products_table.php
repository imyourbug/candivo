<?php

use App\Constants\GlobalConstant;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained('categories');
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('status');
            $table->string('value_status')->nullable();
            $table->tinyInteger('is_basic')->default(GlobalConstant::IS_NOT_BASIC);
            $table->tinyInteger('is_professional')->default(GlobalConstant::IS_NOT_PROFESSIONAL);
            $table->tinyInteger('is_premium')->default(GlobalConstant::IS_NOT_PREMIUM);
            $table->text('avatar')->nullable();
            $table->text('video')->nullable();
            $table->text('images')->nullable();
            $table->timestamps();
            $table->string('cat_set')->nullable();
            $table->string('stand_set')->nullable();

        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
};

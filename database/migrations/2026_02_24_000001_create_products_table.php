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
            $table->string('product_id', 100)->nullable()->comment('PRD + UPPERCASE_SLUG');
            $table->foreignId('category_id')->nullable()->constrained('categories');
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('status');
            $table->string('value_status')->nullable();
            $table->tinyInteger('is_basic')->default(GlobalConstant::IS_NOT_BASIC);
            $table->tinyInteger('is_professional')->default(GlobalConstant::IS_NOT_PROFESSIONAL);
            $table->tinyInteger('is_premium')->default(GlobalConstant::IS_NOT_PREMIUM);
            $table->tinyInteger('is_free')->default(0)->comment('0=paid, 1=free');
            $table->unsignedInteger('duration_1')->nullable()->comment('Duration 1 (months) for price modeling');
            $table->decimal('price_duration_1', 10, 2)->nullable();
            $table->unsignedInteger('duration_2')->nullable()->comment('Duration 2 (months) for price modeling');
            $table->decimal('price_duration_2', 10, 2)->nullable();
            $table->unsignedInteger('duration_3')->nullable()->comment('Duration 3 (months) for price modeling');
            $table->decimal('price_duration_3', 10, 2)->nullable();
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

<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackagesTable extends Migration
{
    public function up()
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('package_id', 100)->nullable()->comment('PKG + UPPERCASE_SLUG');
            $table->foreignId('category_id')->nullable()->constrained('categories');
            $table->string('type_code')->nullable();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('avatar')->nullable();
            $table->text('video')->nullable();
            $table->text('images')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('packages');
    }
};

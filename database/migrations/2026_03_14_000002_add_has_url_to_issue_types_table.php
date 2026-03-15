<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('issue_types', function (Blueprint $table) {
            $table->boolean('has_url')->default(false)->after('description');
        });
    }

    public function down(): void
    {
        Schema::table('issue_types', function (Blueprint $table) {
            $table->dropColumn('has_url');
        });
    }
};

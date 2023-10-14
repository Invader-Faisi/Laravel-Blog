<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * This file is created with command below
     * php artisan make:migration add_meta_fields_to_posts_table
     */
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->string('meta_title', 255)->nullable();
            $table->string('meta_description', 255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn('meta_title');
            $table->dropColumn('meta_description');
        });
    }
};

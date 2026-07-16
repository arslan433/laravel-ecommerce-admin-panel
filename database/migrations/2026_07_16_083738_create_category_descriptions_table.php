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
        Schema::create('category_descriptions', function (Blueprint $table) {
            $table->id();
            $table->integer('category_id');
            $table->integer('language_id')->default(0);
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->string('title_tag')->nullable();
            $table->string('alt_tag')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category_descriptions');
    }
};

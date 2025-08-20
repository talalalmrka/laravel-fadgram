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
        Schema::create('quote_images', function (Blueprint $table) {
            $table->id();
            $table->integer('width')->nullable();
            $table->integer('height')->nullable();
            $table->string('color')->nullable();
            $table->string('border_color')->nullable();
            $table->integer('border_width')->nullable();
            $table->integer('min_font')->nullable();
            $table->integer('max_font')->nullable();
            $table->integer('spacing')->nullable();
            $table->foreignId('font_id')->nullable()->constrained()->onDelete('set null');
            $table->integer('max_lines')->nullable();
            $table->integer('padding')->nullable();
            $table->string('align')->nullable();
            $table->string('valign')->nullable();
            $table->integer('quality')->nullable();
            $table->string('format')->nullable();
            $table->integer('blur')->nullable()->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quote_images');
    }
};

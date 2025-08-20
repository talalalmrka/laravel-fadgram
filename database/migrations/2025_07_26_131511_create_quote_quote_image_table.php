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
        Schema::create('quote_quote_image', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quote_id')->constrained('quotes', 'id')->onDelete('cascade');
            $table->foreignId('quote_image_id')->constrained('quote_images', 'id')->onDelete('cascade');
            /* $table->unsignedBigInteger('quote_id');
            $table->unsignedBigInteger('quote_image_id');
            $table->foreign('quote_id')->references('id')->on('quotes')->onDelete('cascade');
            $table->foreign('quote_image_id')->references('id')->on('quote_images')->onDelete('cascade'); */
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quote_quote_image');
    }
};

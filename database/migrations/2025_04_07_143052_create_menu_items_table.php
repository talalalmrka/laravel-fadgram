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
        Schema::create('menu_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('menu_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->string('name')->nullable();
            $table->string('icon')->nullable();
            $table->integer('order')->default(0);
            $table->enum('type', menu_item_types())->default('custom');
            $table->foreignId('page_id')->nullable()->constrained('posts', 'id')->onDelete('cascade');
            $table->foreignId('post_id')->nullable()->constrained('posts', 'id')->onDelete('cascade');
            $table->foreignId('category_id')->nullable()->constrained('categories', 'id')->onDelete('cascade');
            $table->string('url')->nullable();
            $table->string('class_name')->nullable();
            $table->boolean('navigate')->default(true);
            $table->boolean('new_tab')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_items');
    }
};

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
        Schema::create('blog_post_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('blog_post_id')->nullable()->constrained('blog_posts')->onDelete('cascade');
            $table->string('image_path');
            $table->string('alt_text')->nullable();  // ← No ->after() in CREATE
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            $table->index('blog_post_id'); // Index for faster lookups of post images
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blog_post_images');
    }
};

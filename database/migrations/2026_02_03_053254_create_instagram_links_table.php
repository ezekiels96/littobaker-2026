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
        Schema::create('instagram_links', function (Blueprint $table) {
            $table->id();

            $table->string('label')->nullable();
            $table->string('post_url');   // instagram post/reel url
            $table->string('image_url')->nullable(); // preview image url (optional)
            $table->unsignedInteger('sort_order')->default(0)->index(); // for ordering

            $table->boolean('is_active')->default(true)->index();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('instagram_links');
    }
};

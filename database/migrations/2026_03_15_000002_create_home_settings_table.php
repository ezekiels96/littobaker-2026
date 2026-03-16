<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('home_settings', function (Blueprint $table) {
            $table->id();
            $table->string('hero_heading', 500)->nullable();
            $table->string('hero_image', 2000)->nullable();
            $table->string('feature_heading', 500)->nullable();
            $table->text('feature_text')->nullable();
            $table->string('feature_image', 2000)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('home_settings');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('about_settings', function (Blueprint $table) {
            $table->string('hero_heading', 500)->nullable()->after('id');
            $table->string('hero_tagline', 500)->nullable()->after('hero_heading');
        });
    }

    public function down(): void
    {
        Schema::table('about_settings', function (Blueprint $table) {
            $table->dropColumn(['hero_heading', 'hero_tagline']);
        });
    }
};

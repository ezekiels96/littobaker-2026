<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // The persistent roster of people, split into two services.
        Schema::create('wvac_attendees', function (Blueprint $table) {
            $table->id();
            $table->string('name');                       // English / romanized name
            $table->string('name_zh')->nullable();        // Chinese characters (optional)
            $table->enum('service', ['english', 'chinese']);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['service', 'is_active']);
        });

        // One row per person present on a given Sunday. Presence = row exists.
        Schema::create('wvac_attendance', function (Blueprint $table) {
            $table->id();
            $table->foreignId('attendee_id')->constrained('wvac_attendees')->cascadeOnDelete();
            $table->enum('service', ['english', 'chinese']);
            $table->date('service_date');
            $table->timestamps();

            $table->unique(['attendee_id', 'service_date']);
            $table->index(['service_date', 'service']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wvac_attendance');
        Schema::dropIfExists('wvac_attendees');
    }
};

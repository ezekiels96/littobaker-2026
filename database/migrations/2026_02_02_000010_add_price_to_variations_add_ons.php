<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('variations', function (Blueprint $table) {
            $table->decimal('price', 8, 2)->default(0);
        });
        Schema::table('add_ons', function (Blueprint $table) {
            $table->decimal('price', 8, 2)->default(0);
        });
    }

    public function down(): void
    {
        Schema::table('variations', function (Blueprint $table) {
            $table->dropColumn('price');
        });
        Schema::table('add_ons', function (Blueprint $table) {
            $table->dropColumn('price');
        });
    }
};

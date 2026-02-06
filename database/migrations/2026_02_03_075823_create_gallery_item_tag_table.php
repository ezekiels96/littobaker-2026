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
        Schema::create('gallery_item_tag', function (Blueprint $table) {
            $table->unsignedBigInteger('gallery_item_id');
            $table->unsignedBigInteger('tag_id');

            $table->foreign('gallery_item_id')
                ->references('id')->on('gallery_items')
                ->onDelete('cascade');
            $table->foreign('tag_id')
                ->references('id')->on('tags')
                ->onDelete('cascade');

            $table->primary(['gallery_item_id', 'tag_id']);
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gallery_item_tag');
    }
};

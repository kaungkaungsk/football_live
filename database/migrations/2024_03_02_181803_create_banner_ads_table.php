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
        Schema::create('banner_ads', function (Blueprint $table) {
            $table->id();
            $table->string('media_path')->nullable();
            $table->text('media_link')->nullable();
            $table->string('click_url')->nullable();
            $table->integer('height')->default(60);
            $table->integer('width')->nullable();
            $table->enum('location', [
                'home', 'highlight', 'news', 'movies', 'channels', 'player', 'server',
            ]);
            $table->integer('click_count')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banner_ads');
    }
};

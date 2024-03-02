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
        Schema::table('tv_channels', function (Blueprint $table) {
            $categories = [
                'Myanmar Channels',
                'Movies Channels',
                'Sport Channels',
                'Kids Channels',
                'News Channels',
            ];

            $table->enum('category', $categories);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tv_channels', function (Blueprint $table) {
            $table->dropColumn('category');
        });
    }
};

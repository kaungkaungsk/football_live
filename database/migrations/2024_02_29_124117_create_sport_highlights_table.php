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
        Schema::create('sport_highlights', function (Blueprint $table) {
            $table->id();
            $table->string('referer')->nullable();
            $table->string('link')->nullable();
            $table->enum('link_type', ['Default', 'Youtube'])->nullable();
            $table->string('league');
            $table->dateTime('match_date');
            $table->string('team1_name');
            $table->string('team2_name');
            $table->string('vs');
            $table->string('team1_logo');
            $table->string('team2_logo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sport_highlights');
    }
};

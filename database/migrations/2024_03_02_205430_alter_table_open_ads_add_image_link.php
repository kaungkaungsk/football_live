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
        Schema::table('open_ads', function (Blueprint $table) {
            $table->text('image_link')->nullable();
            $table->text('image')->nullable()->change();
            $table->integer('click_count')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('open_ads', function (Blueprint $table) {
            $table->dropColumn('image_link');
            $table->dropColumn('click_count');
        });
    }
};

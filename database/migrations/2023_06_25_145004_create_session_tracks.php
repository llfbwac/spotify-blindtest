<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('session_tracks', function (Blueprint $table) {
            $table->id();
            $table->integer('session_id');
            $table->string('spotify_track_id');
            $table->string('spotify_track_name');
            $table->string('spotify_track_artist');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('session_tracks');
    }
};
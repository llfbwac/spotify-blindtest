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
        Schema::table('session_tracks', function (Blueprint $table) {
            $table->dropColumn(['spotify_track_id']);
            $table->renameColumn('spotify_track_name', 'name');
            $table->renameColumn('spotify_track_artist', 'artist');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('session_tracks', function (Blueprint $table) {
            //
        });
    }
};
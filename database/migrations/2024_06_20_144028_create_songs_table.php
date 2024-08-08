<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\Playlist;
use App\Models\Artist;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('songs', function (Blueprint $table) {
            $table->id();
            $table->string('title', 100);
            $table->foreignIdFor(Playlist::class);
            $table->foreignIdFor(Artist::class);
            $table->string('file');
            $table->string('cover')->default('default.png');
            // @TODO Duration should be calculated when uploading of song is available
            $table->integer('duration')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('songs');
    }
};

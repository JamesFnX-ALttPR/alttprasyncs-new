<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Race;
use App\Models\Racer;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('results', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Race::class);
            $table->foreignIdFor(Racer::class);
            $table->integer('time');
            $table->boolean('forfeit');
            $table->string('team')->nullable();
            $table->string('comment')->nullable();
            $table->string('vod')->nullable();
            $table->integer('cr')->nullable();
            $table->boolean('from_racetime');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('results');
    }
};

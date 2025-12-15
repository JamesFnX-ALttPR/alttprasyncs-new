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
        Schema::create('series', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description');
            $table->foreignIdFor(\App\Models\User::class);
            $table->timestamps();
        });

        Schema::create('race_series', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Race::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(\App\Models\Series::class)->constrained()->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::create('series_user', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Series::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(\App\Models\User::class)->constrained()->cascadeOnDelete();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('series');
        Schema::dropIfExists('race_series');
    }
};

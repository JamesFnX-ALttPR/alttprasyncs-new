<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Mode;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('races', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignIdFor(Mode::class);
            $table->string('hash');
            $table->text('description')->nullable();
            $table->text('seed');
            $table->timestamp('start_time');
            $table->boolean('team_race')->default(false);
            $table->boolean('spoiler_race')->default(false);
            $table->text('spoiler_log')->nullable();
            $table->boolean('from_racetime')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('races');
    }
};

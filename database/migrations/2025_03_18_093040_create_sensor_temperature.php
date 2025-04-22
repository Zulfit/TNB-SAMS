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
        Schema::create('sensor_temperature', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sensor_id')->constrained('sensors')->onDelete('cascade');
            $table->float('red_phase_temp');
            $table->float('yellow_phase_temp');
            $table->float('blue_phase_temp');
            $table->float('max_temp');
            $table->float('min_temp');
            $table->float('variance_percent');
            $table->enum('alert_triggered', ['normal', 'warn', 'critical'])->default('normal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sensor_temperature');
    }
};

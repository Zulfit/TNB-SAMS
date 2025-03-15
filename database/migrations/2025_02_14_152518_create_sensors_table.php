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
        Schema::create('sensors', function (Blueprint $table) {
            $table->id();
            $table->string('sensor_name');
            $table->string('sensor_panel')->constrained('panels')->onDelete('cascade');
            $table->string('sensor_compartment')->constrained('compartments')->onDelete('cascade');
            $table->foreignId('sensor_substation')->constrained('substations')->onDelete('cascade');
            $table->date('sensor_date');
            $table->string('sensor_status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sensors');
    }
};

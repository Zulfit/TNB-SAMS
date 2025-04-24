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
        Schema::create('sensor_partial_discharge', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sensor_id')->constrained('sensors')->onDelete('cascade');
            $table->float('LFB_Ratio');
            $table->float('LFB_Ratio_Linear');
            $table->float('MFB_Ratio');
            $table->float('MFB_Ratio_Linear');
            $table->float('HFB_Ratio');
            $table->float('HFB_Ratio_Linear');
            $table->float('Mean_Ratio');
            $table->float('LFB_EPPC');
            $table->float('MFB_EPPC');
            $table->float('HFB_EPPC');
            $table->float('Mean_EPPC');
            $table->float('Indicator');
            $table->enum('alert_triggered', ['normal', 'critical'])->default('normal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sensor_partial_discharge');
    }
};

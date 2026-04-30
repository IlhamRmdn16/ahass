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
        Schema::create('unit_entries', function (Blueprint $table) {
            $table->id();
            $table->date('entry_date');
            $table->time('entry_time');
            $table->string('police_number');
            $table->string('motor_type');
            $table->foreignId('mechanic_id')->constrained('mechanics')->onDelete('restrict');
            $table->foreignId('job_type_id')->constrained('job_types')->onDelete('restrict');
            $table->string('phone_number')->nullable();
            $table->boolean('is_daya_auto')->nullable()->default(false);
            $table->text('reason')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unit_entries');
    }
};

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
        Schema::create('encounters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignId('patient_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->integer('body_height');
            $table->decimal('body_weight', 4, 1);
            $table->integer('systole');
            $table->integer('diastole');
            $table->integer('heart_rate');
            $table->integer('respiration_rate');
            $table->decimal('body_temperature', 4, 1);
            $table->text('anamnesis');
            $table->text('diagnosis')->nullable();
            $table->string('other_document')->nullable();
            $table->dateTime('encounter_date');
            $table->enum('status', ['Sudah Selesai', 'Periksa', 'Belum Selesai'])->default('Belum Selesai');
            $table->string('identity', 12)->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('encounters');
    }
};

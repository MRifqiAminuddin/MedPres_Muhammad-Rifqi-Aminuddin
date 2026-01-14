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
        Schema::create('prescriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('encounter_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignId('pharmacist_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();
            $table->enum('status', ['Belum', 'Menunggu', 'Sudah'])->default('Belum');
            $table->dateTime('prescription_date');
            $table->string('identity', 12)->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prescriptions');
    }
};

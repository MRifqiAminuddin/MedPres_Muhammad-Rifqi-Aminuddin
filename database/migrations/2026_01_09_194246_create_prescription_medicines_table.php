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
        Schema::create('prescription_medicines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prescription_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->string('medicine_name');
            $table->string('medicine_id');
            $table->integer('qty');
            $table->string('dosage');
            $table->enum('rule', ['Sebelum Makan', 'Sesudah Makan']);
            $table->enum('status', ['Diberikan', 'Tidak Diberikan'])->nullable();
            $table->index('medicine_id');
            $table->string('identity', 12)->unique();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prescription_medicines');
    }
};

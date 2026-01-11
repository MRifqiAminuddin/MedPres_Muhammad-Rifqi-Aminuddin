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
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete()
                ->unique();
            $table->string('str_number');
            $table->string('sip_number');
            $table->enum('station', [
                'Anak',
                'Anastesi',
                'Andrologi',
                'Bedah Orthopaedi',
                'Bedah Syaraf',
                'Bedah Umum',
                'Bedah Urologi',
                'Gigi dan Mulut',
                'Hamil',
                'Hemodialisis',
                'Jantung',
                'Kandungan',
                'Kulit Kelamin',
                'Mata',
                'Paru',
                'Psikiatri',
                'Psikologi',
                'Rehab Medik',
                'Syaraf',
                'THT',
                'Tumbuh Kembang',
            ]);
            $table->string('identity', 12);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};

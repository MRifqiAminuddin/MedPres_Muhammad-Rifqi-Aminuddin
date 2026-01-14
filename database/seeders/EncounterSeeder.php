<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Faker\Factory as Faker;
use App\Models\Encounter;
use App\Models\Doctor;
use App\Models\Patient;
use Carbon\Carbon;

class EncounterSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        $doctorIds  = Doctor::pluck('id')->toArray();
        $doctorIdCount = count($doctorIds);

        $patientIds = Patient::pluck('id')->toArray();
        $patientIdCount = count($patientIds);

        // Guard clause (ini penting, jangan diabaikan)
        if (empty($doctorIds) || empty($patientIds)) {
            return;
        }

        for ($i = 0; $i < 180; $i++) {
            Encounter::create([
                'doctor_id' => $doctorIds[($i) % $doctorIdCount],
                'patient_id' => $patientIds[($i) % $patientIdCount],

                'body_height' => $faker->numberBetween(145, 185),
                'body_weight' => $faker->randomFloat(1, 40, 95),

                'systole' => $faker->numberBetween(100, 140),
                'diastole' => $faker->numberBetween(60, 90),

                'heart_rate' => $faker->numberBetween(60, 100),
                'respiration_rate' => $faker->numberBetween(12, 20),
                'body_temperature' => $faker->randomFloat(1, 36.0, 38.5),

                'anamnesis' => $faker->sentence(12),
                'diagnosis' => $faker->sentence(6),

                'other_document' => $faker->optional(0.3)->filePath(),

                'encounter_date' => Carbon::now(),

                'status' => $faker->randomElement(['Sudah Selesai', 'Belum Selesai']),

                'identity' => Str::upper(Str::random(10)),
            ]);
        }
    }
}

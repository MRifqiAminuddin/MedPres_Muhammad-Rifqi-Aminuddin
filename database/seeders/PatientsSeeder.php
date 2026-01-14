<?php

namespace Database\Seeders;

use App\Models\Patient;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class PatientsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $patients = [
            [
                'name' => 'Ahmad Prasetyo',
                'birth_date' => '1990-04-12',
                'gender' => 'Laki Laki'
            ],
            [
                'name' => 'Siti Aisyah Rahma',
                'birth_date' => '1985-09-23',
                'gender' => 'Perempuan'
            ],
            [
                'name' => 'Budi Santoso',
                'birth_date' => '1978-01-05',
                'gender' => 'Laki Laki'
            ],
            [
                'name' => 'Dewi Lestari',
                'birth_date' => '1995-12-30',
                'gender' => 'Perempuan'
            ],
            [
                'name' => 'Rizky Maulana',
                'birth_date' => '2001-07-18',
                'gender' => 'Laki Laki'
            ],
        ];

        foreach ($patients as $data) {
            Patient::create([
                'medical_record_number' => rand(1000000000, 9999999999),
                'name' => $data['name'],
                'birth_date' => $data['birth_date'],
                'gender' => $data['gender'],
                'identity' => Str::upper(Str::random(10))
            ]);
        }
    }
}

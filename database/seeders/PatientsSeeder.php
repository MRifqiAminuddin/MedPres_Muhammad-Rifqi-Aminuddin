<?php

namespace Database\Seeders;

use App\Models\Patient;
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
            ],
            [
                'name' => 'Siti Aisyah Rahma',
                'birth_date' => '1985-09-23',
            ],
            [
                'name' => 'Budi Santoso',
                'birth_date' => '1978-01-05',
            ],
            [
                'name' => 'Dewi Lestari',
                'birth_date' => '1995-12-30',
            ],
            [
                'name' => 'Rizky Maulana',
                'birth_date' => '2001-07-18',
            ],
        ];

        foreach ($patients as $data) {
            Patient::create($data);
        }
    }
}

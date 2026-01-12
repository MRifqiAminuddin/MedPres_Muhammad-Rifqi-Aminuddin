<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class DoctorsSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        $stations = [
            'Anak',
            'Anastesi',
            'Andrologi',
            'Bedah Orthopaedi',
            'Bedah Syaraf',
            'Bedah Umum',
            'Bedah Urologi',
            'Gigi dan Mulut',
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
        ];

        for ($i = 1; $i <= 60; $i++) {
            $gender = $faker->randomElement(['Laki', 'Perempuan']);

            $user = User::create([
                'name' => 'dr. ' . $faker->name($gender === 'Laki' ? 'male' : 'female'),
                'role' => 'Dokter',
                'gender' => $gender,
                'email' => $faker->unique()->safeEmail(),
                'password' => bcrypt('12345678'),
                'activation' => true,
                'identity' => Str::random(10),
            ]);

            $user->doctor()->create([
                'str_number' => sprintf(
                    'STR-%04d-202%d-%07d',
                    rand(1000, 9999),
                    rand(0, 4),
                    rand(1000000, 9999999)
                ),
                'sip_number' => sprintf(
                    'SIP-%03d/%04d/DINKES/202%d',
                    rand(100, 999),
                    rand(1000, 9999),
                    rand(2, 4)
                ),
                'station' => $stations[array_rand($stations)],
                'identity' => Str::random(10),
            ]);
        }

        $user = User::create([
            'name' => 'Prof. dr. Soemarso',
            'role' => 'Dokter',
            'gender' => 'Laki',
            'email' => 'dr.soemarso@gmail.com',
            'password' => bcrypt('12345678'),
            'activation' => true,
            'identity' => Str::random(10),
        ]);

        $user->doctor()->create([
            'str_number' => sprintf(
                'STR-%04d-202%d-%07d',
                rand(1000, 9999),
                rand(0, 4),
                rand(1000000, 9999999)
            ),
            'sip_number' => sprintf(
                'SIP-%03d/%04d/DINKES/202%d',
                rand(100, 999),
                rand(1000, 9999),
                rand(2, 4)
            ),
            'station' => $stations[array_rand($stations)],
            'identity' => Str::random(10),
        ]);
    }
}

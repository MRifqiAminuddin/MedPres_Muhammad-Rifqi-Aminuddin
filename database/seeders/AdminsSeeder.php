<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class AdminsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
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

        $stationCount = count($stations);

        for ($i = 1; $i <= 30; $i++) {
            $gender = $faker->randomElement(['Laki Laki', 'Perempuan']);

            $user = User::create([
                'name'       => $faker->name($gender === 'Laki Laki' ? 'male' : 'female'),
                'role'       => 'Admin',
                'gender'     => $gender,
                'email'      => $faker->unique()->safeEmail(),
                'password'   => bcrypt('12345678'),
                'activation' => true,
                'identity'   => Str::upper(Str::random(10)),
            ]);

            $user->admin()->create([
                'station' => $stations[($i - 1) % $stationCount],
                'identity' => Str::upper(Str::random(10)),
            ]);
        }

        User::create([
            'name' => 'Admin Pusat',
            'role' => 'Super Admin',
            'gender' => 'Laki Laki',
            'email' => 'superadmin@gmail.com',
            'password' => bcrypt('12345678'),
            'activation' => true,
            'identity' => Str::upper(Str::random(10))
        ]);

        $user = User::create([
            'name' => 'Yoni',
            'role' => 'Admin',
            'gender' => 'Laki Laki',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('12345678'),
            'activation' => true,
            'identity' => Str::upper(Str::random(10))
        ]);

        $user->admin()->create([
            'station' => 'Anak',
            'identity' => Str::upper(Str::random(10))
        ]);
    }
}

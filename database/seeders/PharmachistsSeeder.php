<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class PharmachistsSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        for ($i = 1; $i <= 20; $i++) {
            $gender = $faker->randomElement(['Laki', 'Perempuan']);

            $user = User::create([
                'name' => 'apt. ' . $faker->name($gender === 'Laki' ? 'male' : 'female') . ', S.Farm',
                'role' => 'Apoteker',
                'gender' => $gender,
                'email' => $faker->unique()->safeEmail(),
                'password' => bcrypt('12345678'),
                'activation' => true,
                'identity' => Str::random(10),
            ]);

            $user->pharmacist()->create([
                'str_number' => sprintf(
                    'STRA-%04d-202%d-%07d',
                    rand(1000, 9999),
                    rand(0, 4),
                    rand(1000000, 9999999)
                ),
                'identity' => Str::random(10),
            ]);
        }

        $user = User::create([
            'name' => 'apt. Rani Murbiti, S.Farm',
            'role' => 'Apoteker',
            'gender' => 'Perempuan',
            'email' => 'apt.rani@gmail.com',
            'password' => bcrypt('12345678'),
            'activation' => true,
            'identity' => Str::random(10),
        ]);

        $user->pharmacist()->create([
            'str_number' => sprintf(
                'STRA-%04d-202%d-%07d',
                rand(1000, 9999),
                rand(0, 4),
                rand(1000000, 9999999)
            ),
            'identity' => Str::random(10),
        ]);
    }
}

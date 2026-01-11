<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class PharmachistsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'apt. Rina Oktaviani, S.Farm',
                'gender' => 'Perempuan',
                'email' => 'rina.apt@gmail.com',
                'str_number' => 'STRA-3274-2019-0004821',
            ],
            [
                'name' => 'apt. Dimas Pratama, S.Farm',
                'gender' => 'Laki',
                'email' => 'dimas.apt@gmail.com',
                'str_number' => 'STRA-3312-2020-0007392',
            ],
            [
                'name' => 'apt. Siti Nurhaliza, S.Farm',
                'gender' => 'Perempuan',
                'email' => 'siti.apt@gmail.com',
                'str_number' => 'STRA-3506-2021-0006154',
            ],
            [
                'name' => 'apt. Ahmad Fauzan, S.Farm',
                'gender' => 'Laki',
                'email' => 'ahmad.apt@gmail.com',
                'str_number' => 'STRA-3171-2018-0002987',
            ],
        ];

        foreach ($users as $data) {
            $user = User::create([
                'name' => $data['name'],
                'role' => 'Apoteker',
                'gender' => $data['gender'],
                'email' => $data['email'],
                'password' => bcrypt('12345678'),
                'activation' => true,
                'identity' => Str::random(10)
            ]);

            $user->pharmacists()->create([
                'str_number' => $data['str_number'],
                'identity' => Str::random(10)
            ]);
        }
    }
}

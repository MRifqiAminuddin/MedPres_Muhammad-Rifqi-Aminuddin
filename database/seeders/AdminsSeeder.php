<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class AdminsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Super Admin',
                'gender' => 'Laki',
                'email' => 'superadmin@gmail.com',
            ],
            [
                'name' => 'admin',
                'gender' => 'Perempuan',
                'email' => 'admin@gmail.com',
            ],
            [
                'name' => 'Bobi Putra Dewa',
                'gender' => 'Laki',
                'email' => 'bobi@gmail.com',
            ],
            [
                'name' => 'Bunga Putri Melati',
                'gender' => 'Perempuan',
                'email' => 'bunga@gmail.com',
            ],
        ];

        foreach ($users as $data) {
            User::create([
                'name' => $data['name'],
                'role' => 'Admin',
                'gender' => $data['gender'],
                'email' => $data['email'],
                'password' => bcrypt('12345678'),
                'activation' => true,
            ]);
        }
    }
}

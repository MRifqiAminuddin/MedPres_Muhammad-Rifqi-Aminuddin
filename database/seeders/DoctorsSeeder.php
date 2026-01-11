<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class DoctorsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'dr. Haris Hutapea',
                'gender' => 'Laki',
                'email' => 'dr.haris@gmail.com',
                'str_number' => 'STR-4136-2020-0003629',
                'sip_number' => 'SIP-499/1042/DINKES/2023',
                'station' => 'Mata',
            ],
            [
                'name' => 'dr. Umi Saadah',
                'gender' => 'Perempuan',
                'email' => 'dr.umi@gmail.com',
                'str_number' => 'STR-9923-2022-0007602',
                'sip_number' => 'SIP-502/4902/DINKES/2022',
                'station' => 'Anak',
            ],
            [
                'name' => 'dr. Yuli Panca Utami',
                'gender' => 'Perempuan',
                'email' => 'dr.yuli@gmail.com',
                'str_number' => 'STR-2094-2021-0007729',
                'sip_number' => 'SIP-681/2305/DINKES/2024',
                'station' => 'Bedah Umum',
            ],
            [
                'name' => 'dr. Rudi Sulaiman',
                'gender' => 'Laki',
                'email' => 'dr.rudi@gmail.com',
                'str_number' => 'STR-3210-2021-0009245',
                'sip_number' => 'SIP-172/5823/DINKES/2023',
                'station' => 'Kandungan',
            ],
        ];

        foreach ($users as $data) {
            $user = User::create([
                'name' => $data['name'],
                'role' => 'Dokter',
                'gender' => $data['gender'],
                'email' => $data['email'],
                'password' => bcrypt('12345678'),
                'activation' => true,
            ]);

            $user->doctors()->create([
                'str_number' => $data['str_number'],
                'sip_number' => $data['sip_number'],
                'station' => $data['station'],
            ]);
        }
    }
}

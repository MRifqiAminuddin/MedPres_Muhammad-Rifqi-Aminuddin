<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Variable;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class VariablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $response = Http::post(
            'http://recruitment.rsdeltasurya.com/api/v1/auth',
            [
                'email'    => 'mrifqi767@gmail.com',
                'password' => '087754196023',
            ]
        );

        if ($response->failed()) {
            Log::error('Auth API request failed', [
                'status' => $response->status(),
                'body'   => $response->body(),
            ]);

            return;
        }

        $data = $response->json();

        if (isset($data['access_token'])) {
            Variable::create([
                'name' => 'Login',
                'content' => $data['access_token'],
                'identity' => Str::upper(Str::random(10))
            ]);
        }
    }
}

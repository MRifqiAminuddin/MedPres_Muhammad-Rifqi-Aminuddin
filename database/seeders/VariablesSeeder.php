<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Variable;

class VariablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Variable::create([
            'name' => 'Login',
            'content' => 'a0cf6cbe-a415-43a7-a04a-7eb99172107f|fsZiU9uVz1Via1MNmQ7NOaOf6Nd3m7uZQ8XdQEo0082dc36f'
        ]);
    }
}

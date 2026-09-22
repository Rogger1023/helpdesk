<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Responsavel;

class ResponsavelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Responsavel::firstOrCreate([
            'nome' => 'Ana Silva',
            'email' => 'ana@empresa.com',
        ]);

        Responsavel::firstOrCreate([
            'nome' => 'Carlos Lima',
            'email' => 'carlos@empresa.com',
        ]);

        Responsavel::firstOrCreate([
            'nome' => 'João Souza',
            'email' => 'joao@empresa.com',
        ]);
    }
}

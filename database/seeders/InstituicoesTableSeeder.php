<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InstituicoesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('instituicoes')->insert([
            'nome' => 'Banco do Brasil',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}

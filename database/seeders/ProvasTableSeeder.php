<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProvasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $bancaId = DB::table('bancas')->where('nome', 'Cesgranrio')->first()->id;
        $instituicaoId = DB::table('instituicoes')->where('nome', 'Banco do Brasil')->first()->id;

        DB::table('provas')->insert([
            'banca_id' => $bancaId,
            'instituicao_id' => $instituicaoId,
            'titulo' => 'Agente de Tecnologia',
            'ano' => 2021,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}

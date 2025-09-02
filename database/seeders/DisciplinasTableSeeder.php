<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DisciplinasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $disciplinas = [
            'Língua Portuguesa',
            'Língua Inglesa',
            'Matemática',
            'Atualidades do Mercado Financeiro',
            'Probabilidade e Estatística',
            'Conhecimentos Bancários',
            'Tecnologia da Informação',
        ];

        foreach ($disciplinas as $disciplina) {
            DB::table('disciplinas')->insert([
                'nome' => $disciplina,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

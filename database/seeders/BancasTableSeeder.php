<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BancasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('bancas')->insert([
            'nome' => 'Cesgranrio',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}

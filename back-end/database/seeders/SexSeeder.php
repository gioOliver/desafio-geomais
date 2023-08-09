<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SexSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('sex')->insert([
            'id'    => 1,
            'name'  => 'Masculino'
        ]);
        DB::table('sex')->insert([
            'id'    => 2,
            'name'  => 'Feminino'
        ]);
    }
}

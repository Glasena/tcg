<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class TcgTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tcg_types')->insert([
            'description' => 'Yu-Gi-Oh!',
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);
    }
}

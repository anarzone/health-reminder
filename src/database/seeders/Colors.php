<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Colors extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('colors')->insert([
            ['code' => '#F08080', 'order' => 1],
            ['code' => '#FFA07A', 'order' => 2],
            ['code' => '#6495ED', 'order' => 3],
            ['code' => '#40E0D0', 'order' => 4],
            ['code' => '#DFFF00', 'order' => 5],
            ['code' => '#CCCCFF', 'order' => 6],
            ['code' => '#76D7C4', 'order' => 7],
            ['code' => '#F7F9F9', 'order' => 8],
        ]);
    }
}

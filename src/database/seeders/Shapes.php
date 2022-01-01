<?php

namespace Database\Seeders;

use App\Models\Shape;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class Shapes extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $shapes = [
            ['name' => json_encode(
                [
                    'az' => 'Yumru',
                    'en' => 'Round',
                ])],
            ['name' => json_encode(
                [
                    'az' => 'Oval',
                    'en' => 'Oval',
                ])],
            ['name' => json_encode(
                [
                    'az' => 'Kapsul',
                    'en' => 'Capsule',
                ])
            ],
            ['name' => json_encode(
                [
                    'az' => 'Dördbucaqlı',
                    'en' => 'Square',
                ])
            ],
        ];

        Schema::disableForeignKeyConstraints();
        Shape::truncate();
        Shape::insert($shapes);
        Schema::enableForeignKeyConstraints();
    }
}

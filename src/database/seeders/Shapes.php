<?php

namespace Database\Seeders;

use App\Models\Shape;
use Illuminate\Database\Seeder;

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
            ['name' => json_encode([
                'az' => 'Round',
                'en' => 'Yumru',
            ])],
            ['name' => json_encode([
                'az' => 'Oval',
                'en' => 'Oval',
            ])],
            ['name' => json_encode([
                'az' => 'Dördbucaqlı',
                'en' => 'Rectangle',
            ])],
        ];

        Shape::insert($shapes);
    }
}

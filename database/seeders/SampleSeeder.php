<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SampleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('products')->insert([
            [
                'name' => 'Sample Product 1',
                'price' => 100,
                'stock' => 10,
            ],
            [
                'name' => 'Sample Product 2',
                'price' => 50,
                'stock' => 20,
            ],
        ]);
    }
}

<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::Insert([
            [
                'name' => 'Product 1',
                'price' => 123
            ],
            [
                'name' => 'Product 2',
                'price' => 456
            ],
            [
                'name' => 'Product 3',
                'price' => 789
            ],
        ]);
    }
}

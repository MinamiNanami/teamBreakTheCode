<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::insert([
            ['name' => 'Adobo', 'category' => 'main', 'price' => 120],
            ['name' => 'Tapsilog', 'category' => 'silog', 'price' => 95],
            ['name' => 'Pancit Canton', 'category' => 'Pancit', 'price' => 85],
            ['name' => 'Plain Rice', 'category' => 'Rice', 'price' => 20],
            ['name' => 'Coke', 'category' => 'beverages', 'price' => 35],
        ]);
    }
}

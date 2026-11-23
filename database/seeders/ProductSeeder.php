<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'category' => 'Guitars',
                'name' => 'Electric Guitar',
                'description' => 'An electric guitar suitable for rehearsals, recording, and live performances.',
                'price' => 450000,
                'stock_quantity' => 10,
            ],
            [
                'category' => 'Guitars',
                'name' => 'Acoustic Guitar',
                'description' => 'An acoustic guitar suitable for practice, songwriting, and performances.',
                'price' => 280000,
                'stock_quantity' => 8,
            ],
            [
                'category' => 'Speakers',
                'name' => 'Studio Monitor Speaker',
                'description' => 'A monitor speaker for music production and audio monitoring.',
                'price' => 350000,
                'stock_quantity' => 6,
            ],
            [
                'category' => 'Accessories',
                'name' => 'Guitar Cable',
                'description' => 'An instrument cable for connecting a guitar to an amplifier or audio interface.',
                'price' => 25000,
                'stock_quantity' => 30,
            ],
            [
                'category' => 'Keyboards',
                'name' => 'MIDI Keyboard',
                'description' => 'A MIDI controller for music production and virtual instruments.',
                'price' => 320000,
                'stock_quantity' => 5,
            ],
        ];

        foreach ($products as $data) {
            $category = Category::where(
                'slug',
                Str::slug($data['category'])
            )->firstOrFail();

            Product::updateOrCreate(
                ['slug' => Str::slug($data['name'])],
                [
                    'category_id' => $category->id,
                    'name' => $data['name'],
                    'description' => $data['description'],
                    'price' => $data['price'],
                    'stock_quantity' => $data['stock_quantity'],
                    'is_active' => true,
                ]
            );
        }
    }
}
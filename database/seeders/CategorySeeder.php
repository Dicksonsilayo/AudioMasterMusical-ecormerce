<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Guitars',
                'description' => 'Electric, acoustic, and bass guitars.',
            ],
            [
                'name' => 'Speakers',
                'description' => 'Studio monitors, PA speakers, and sound systems.',
            ],
            [
                'name' => 'Accessories',
                'description' => 'Cables, strings, picks, and other music accessories.',
            ],
            [
                'name' => 'Keyboards',
                'description' => 'Digital keyboards, synthesizers, and MIDI controllers.',
            ],
        ];

        foreach ($categories as $data) {
            Category::updateOrCreate(
                ['slug' => Str::slug($data['name'])],
                [
                    'name' => $data['name'],
                    'description' => $data['description'],
                    'is_active' => true,
                ]
            );
        }
    }
}
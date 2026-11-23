<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        
        $this->call([
            CategorySeeder::class,
            ProductSeeder::class,
        ]);
User::firstOrCreate(
    ['email' => 'dickson1@gmail.com'],
    [
        'name' => 'dickson1',
        'password' => bcrypt('dickson@123'),
        'role' => 'customer',
    ]
);
    }
}

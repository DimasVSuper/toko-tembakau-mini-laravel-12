<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Membuat 10 user beserta kategori dan transaksi dummy
        \App\Models\User::factory(10)->create()->each(function ($user) {
            $categories = \App\Models\Categories::factory(3)->create(['user_id' => $user->id]);
            $categories->each(function ($category) use ($user) {
                \App\Models\Transactions::factory(5)->create([
                    'user_id' => $user->id,
                    'category_id' => $category->id,
                ]);
            });
        });

        // Optional: user khusus untuk login manual
        \App\Models\User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password')
        ]);
    }
}

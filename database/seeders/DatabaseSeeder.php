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
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'user',
            'email' => 'user@example.com',
            'phone' => '081234567890',
            'password' => bcrypt('password'),
        ]);

        $this->call([\Database\Seeders\ExamBankSeeder::class]);
        $this->call([LearningSeeder::class,]);
    }
}

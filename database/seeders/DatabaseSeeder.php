<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        User::create([
            'name' => 'John Doe',
            'password' => '$2y$12$S3FdtNmI5YsEiwnhjnJLN.T6RMsxmLi8jb4m.E6pBgO6sNnNFstA.',
            'email' => 'doe@gmail.com',
        ]);


        \App\Models\Recipe::factory(10)->create();
    }
}

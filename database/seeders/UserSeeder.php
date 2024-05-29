<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'John Doe',
            'password' => '$2y$12$S3FdtNmI5YsEiwnhjnJLN.T6RMsxmLi8jb4m.E6pBgO6sNnNFstA.', // password
            'email' => 'doe@gmail.com',
        ]);

        User::create([
            'name' => 'John Second',
            'password' => '$2y$12$S3FdtNmI5YsEiwnhjnJLN.T6RMsxmLi8jb4m.E6pBgO6sNnNFstA.',
            'email' => 'secondjoe@gmail.com',
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User; // Import class user

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Is a user with this email does not exist, create one
        User::updateOrCreate(
            ['email' => 'admin@blog.test'],
            [
                'name' => 'Administrador',
                'password' => bcrypt('password'),
                'role' => 'admin',
            ]
        );
    }
}

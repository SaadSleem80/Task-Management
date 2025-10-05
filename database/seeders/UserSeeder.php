<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $manager = User::create([
            'name' => 'Manager',
            'email' => 'manager@softexpert.com',
            'password' => bcrypt('password'),
        ]);
        $manager->assignRole('manager');

        $user = User::create([
            'name' => 'User',
            'email' => 'user@softexpert.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('user');
    }
}

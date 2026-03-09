<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        $users = [
            ['name' => 'Dhruv Shah',   'email' => 'dhruv@example.com'],
            ['name' => 'Ravi Patel',   'email' => 'ravi@example.com'],
            ['name' => 'Neha Mehta',   'email' => 'neha@example.com'],
        ];

        foreach ($users as $user) {
            User::create([
                'name'     => $user['name'],
                'email'    => $user['email'],
                'password' => Hash::make('password'),
                'is_admin' => false,
            ]);
        }
    }
}

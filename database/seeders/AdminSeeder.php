<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = \App\Models\User::create([
            'name' => 'Admin Pengurus',
            'npm' => 12345678,
            'email' => 'admin@sikelas.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role' => 'pengurus',
        ]);
    }
}

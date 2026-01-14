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

        $student = \App\Models\User::create([
            'name' => 'Ahmad Mahasiswa',
            'npm' => 22001122,
            'email' => 'ahmad@student.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role' => 'mahasiswa',
        ]);

        \App\Models\Account::create(['user_id' => $student->id]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AcademicCourse;
use App\Models\AcademicTask;
use App\Models\User;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Bendahara (Full Finance)
        User::create([
            'name' => 'Bendahara Kelas',
            'npm' => 123,
            'email' => 'bendahara@sikelas.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role' => 'bendahara',
        ]);

        // Sekertaris (Schedule & Assignments)
        User::create([
            'name' => 'Sekertaris Kelas',
            'npm' => 456,
            'email' => 'sekertaris@sikelas.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role' => 'sekertaris',
        ]);

        // Default Student (For testing)
        $student = User::create([
            'name' => 'Mahasiswa Contoh',
            'npm' => 24340001,
            'email' => '24340001@student.sikelas.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role' => 'mahasiswa',
        ]);
        \App\Models\Account::create(['user_id' => $student->id]);

        // Sample Academic Courses
        $pbo = AcademicCourse::create([
            'course_name' => 'Pemrograman Berorientasi Objek',
            'instructor_name' => 'Dr. Budi Santoso',
            'day' => 'Senin',
            'start_time' => '08:00:00',
            'end_time' => '10:30:00',
            'location' => 'Lab Komputer 1',
            'credit_units' => 3
        ]);

        $db = AcademicCourse::create([
            'course_name' => 'Basis Data',
            'instructor_name' => 'Ir. Siti Aminah',
            'day' => 'Selasa',
            'start_time' => '13:00:00',
            'end_time' => '15:00:00',
            'location' => 'Ruang 302',
            'credit_units' => 2
        ]);

        // Sample Academic Tasks (Now linked to courses)
        AcademicTask::create([
            'academic_course_id' => $db->id,
            'task_title' => 'Project Basis Data: ERD Design',
            'task_description' => 'Membuat diagram ERD lengkap untuk sistem perpustakaan.',
            'due_date' => now()->addDays(5),
            'status' => 'active'
        ]);

        AcademicTask::create([
            'academic_course_id' => $pbo->id,
            'task_title' => 'Laporan Praktikum Java',
            'task_description' => 'Kumpulkan file PDF laporan praktikum mingguan.',
            'due_date' => now()->addDays(2),
            'status' => 'active'
        ]);
    }
}

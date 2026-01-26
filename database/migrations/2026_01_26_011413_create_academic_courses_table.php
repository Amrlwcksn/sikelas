<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('academic_courses', function (Blueprint $blueprint) {
            $blueprint->id();
            $blueprint->string('course_name'); // Nama Mata Kuliah
            $blueprint->string('instructor_name'); // Nama Dosen
            $blueprint->string('day');
            $blueprint->time('start_time');
            $blueprint->time('end_time');
            $blueprint->string('location')->nullable(); // Ruangan
            $blueprint->integer('credit_units')->default(2); // SKS
            $blueprint->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('academic_courses');
    }
};

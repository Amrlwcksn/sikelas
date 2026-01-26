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
        Schema::create('academic_tasks', function (Blueprint $blueprint) {
            $blueprint->id();
            $blueprint->foreignId('academic_course_id')->constrained('academic_courses')->onDelete('cascade');
            $blueprint->string('task_title');
            $blueprint->text('task_description')->nullable();
            $blueprint->dateTime('due_date');
            $blueprint->enum('status', ['active', 'closed'])->default('active');
            $blueprint->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('academic_tasks');
    }
};

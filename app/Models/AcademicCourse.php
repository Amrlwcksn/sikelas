<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AcademicCourse extends Model
{
    protected $fillable = [
        'course_name',
        'instructor_name',
        'day',
        'start_time',
        'end_time',
        'location',
        'credit_units',
    ];

    /**
     * Get all tasks for the course.
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(AcademicTask::class, 'academic_course_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AcademicTask extends Model
{
    protected $fillable = [
        'academic_course_id',
        'task_title',
        'task_description',
        'due_date',
        'status',
    ];

    /**
     * Get the course that owns the task.
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(AcademicCourse::class, 'academic_course_id');
    }
}

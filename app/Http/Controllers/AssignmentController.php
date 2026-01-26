<?php

namespace App\Http\Controllers;

use App\Models\AcademicTask;
use App\Models\AcademicCourse;
use Illuminate\Http\Request;

class AssignmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $assignments = AcademicTask::with('course')->orderBy('due_date')->get();
        $academic_courses = AcademicCourse::orderBy('course_name')->get();
        
        if (request()->routeIs('admin.*')) {
            return view('admin.assignments.index', compact('assignments', 'academic_courses'));
        }
        
        return view('assignments.index', compact('assignments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'academic_course_id' => 'required|exists:academic_courses,id',
            'task_title' => 'required|string|max:255',
            'due_date' => 'required',
            'task_description' => 'nullable|string',
        ]);

        AcademicTask::create([
            'academic_course_id' => $request->academic_course_id,
            'task_title' => $request->task_title,
            'task_description' => $request->task_description,
            'due_date' => $request->due_date,
            'status' => 'active',
        ]);

        return redirect()->back()->with('success', 'Tugas baru berhasil diumumkan!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AcademicTask $assignment)
    {
        $assignment->update(['status' => $request->status]);
        return redirect()->back()->with('success', 'Status tugas berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AcademicTask $assignment)
    {
        $assignment->delete();
        return redirect()->back()->with('success', 'Tugas berhasil dihapus!');
    }
}

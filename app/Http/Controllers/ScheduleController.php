<?php

namespace App\Http\Controllers;

use App\Models\AcademicCourse;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $schedules = AcademicCourse::orderByRaw("FIELD(day, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu')")
            ->orderBy('start_time')
            ->get();
            
        if (request()->routeIs('admin.*')) {
            return view('admin.schedules.index', compact('schedules'));
        }
        
        return view('schedules.index', compact('schedules'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'course_name' => 'required|string|max:255',
            'instructor_name' => 'required|string|max:255',
            'day' => 'required|string',
            'start_time' => 'required',
            'end_time' => 'required',
            'location' => 'nullable|string',
            'credit_units' => 'required|integer|min:1',
        ]);

        AcademicCourse::create($request->all());

        return redirect()->back()->with('success', 'Jadwal Kuliah berhasil ditambahkan!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AcademicCourse $schedule)
    {
        $schedule->delete();
        return redirect()->back()->with('success', 'Jadwal Kuliah berhasil dihapus!');
    }
}

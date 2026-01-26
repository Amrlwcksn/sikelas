<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Student\StudentController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\AssignmentController;

Route::get('/', function () {
    return redirect()->route('login');
});

// Redirect dashboard based on role
Route::get('/dashboard', function () {
    if (in_array(auth()->user()->role, ['bendahara', 'sekertaris'])) {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('student.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Admin Common Routes (Bendahara & Sekertaris)
Route::middleware(['auth', 'role:bendahara,sekertaris'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
});

// Bendahara Specific Routes
Route::middleware(['auth', 'role:bendahara'])->prefix('admin')->group(function () {
    Route::get('/students', [AdminController::class, 'students'])->name('admin.students');
    Route::get('/transactions', [AdminController::class, 'transactions'])->name('admin.transactions');
    Route::post('/transactions', [AdminController::class, 'storeTransaction'])->name('admin.transactions.store');
    Route::get('/rekap', [AdminController::class, 'rekap'])->name('admin.rekap');
    Route::get('/registrasi', [AdminController::class, 'registrasi'])->name('admin.registrasi');
    Route::post('/registrasi', [AdminController::class, 'storeStudent'])->name('admin.registrasi.store');
    Route::get('/cek-saldo', [AdminController::class, 'cekSaldo'])->name('admin.cek-saldo');

    // Payment Validation
    Route::get('/payments', [PaymentController::class, 'validasi'])->name('admin.payments.validasi');
    Route::post('/payments/{payment}/approve', [PaymentController::class, 'approve'])->name('admin.payments.approve');
    Route::post('/payments/{payment}/reject', [PaymentController::class, 'reject'])->name('admin.payments.reject');
});

// Sekertaris Specific Routes
Route::middleware(['auth', 'role:sekertaris'])->prefix('admin')->group(function () {
    Route::resource('schedules', ScheduleController::class)->names('admin.schedules');
    Route::resource('assignments', AssignmentController::class)->names('admin.assignments');
});

// Student Routes
Route::middleware(['auth', 'role:mahasiswa'])->prefix('student')->group(function () {
    Route::get('/dashboard', [StudentController::class, 'dashboard'])->name('student.dashboard');
    Route::get('/settings', [StudentController::class, 'settings'])->name('student.settings');
    Route::post('/update-password', [StudentController::class, 'updatePassword'])->name('student.update-password');

    // New Features
    Route::get('/pay', [PaymentController::class, 'index'])->name('student.pay');
    Route::post('/pay', [PaymentController::class, 'store'])->name('student.pay.store');
    Route::get('/schedules', [ScheduleController::class, 'index'])->name('student.schedules');
    Route::get('/assignments', [AssignmentController::class, 'index'])->name('student.assignments');
});

// End of Routes

require __DIR__.'/auth.php';

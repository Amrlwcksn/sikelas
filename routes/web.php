<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Student\StudentController;

Route::get('/', function () {
    return redirect()->route('login');
});

// Redirect dashboard based on role
Route::get('/dashboard', function () {
    if (auth()->user()->role === 'pengurus') {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('student.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Admin Routes
Route::middleware(['auth', 'role:pengurus'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/students', [AdminController::class, 'students'])->name('admin.students');
    Route::get('/transactions', [AdminController::class, 'transactions'])->name('admin.transactions');
    Route::post('/transactions', [AdminController::class, 'storeTransaction'])->name('admin.transactions.store');
    Route::get('/rekap', [AdminController::class, 'rekap'])->name('admin.rekap');
    Route::get('/registrasi', [AdminController::class, 'registrasi'])->name('admin.registrasi');
    Route::post('/registrasi', [AdminController::class, 'storeStudent'])->name('admin.registrasi.store');
    Route::get('/cek-saldo', [AdminController::class, 'cekSaldo'])->name('admin.cek-saldo');
});

// Student Routes
Route::middleware(['auth', 'role:mahasiswa'])->prefix('student')->group(function () {
    Route::get('/dashboard', [StudentController::class, 'dashboard'])->name('student.dashboard');
    Route::get('/settings', [StudentController::class, 'settings'])->name('student.settings');
    Route::post('/update-password', [StudentController::class, 'updatePassword'])->name('student.update-password');
});

// End of Routes

require __DIR__.'/auth.php';

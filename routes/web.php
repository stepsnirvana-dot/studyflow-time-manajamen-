<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ProfileController;

// Rute Utama Aplikasi (Wajib Login & Terverifikasi)
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard Kanban Utama
    Route::get('/', [TaskController::class, 'index'])->name('dashboard');
    Route::redirect('/dashboard', '/');

    // Manajemen Task
    Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
    Route::patch('/tasks/{task}/status', [TaskController::class, 'updateStatus'])->name('tasks.updateStatus');

    // Halaman Menu Lainnya
    Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
    Route::get('/focus', [CourseController::class, 'focus'])->name('focus.index');
    Route::get('/calendar', [CourseController::class, 'calendar'])->name('calendar.index');

    // Pengaturan Profil (Bawaan Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Rute Auth Breeze (Login, Register, Logout, dll)
require __DIR__.'/auth.php';
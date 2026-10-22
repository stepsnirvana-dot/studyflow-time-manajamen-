<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ProfileController;

/*
| Web Routes
*/

// Halaman Depan / Landing Page (Dapat diakses tanpa login)
Route::get('/', function () {
    return view('welcome');
});

// Rute Utama Aplikasi (Wajib Login & Terverifikasi)
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard Kanban Utama
    Route::get('/dashboard', [TaskController::class, 'index'])->name('dashboard');

    // Manajemen Task
    Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
    Route::patch('/tasks/{task}/status', [TaskController::class, 'updateStatus'])->name('tasks.updateStatus');

    // Halaman Menu Lainnya
    Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
    Route::post('/courses', [CourseController::class, 'store'])->name('courses.store');
    Route::get('/focus', [CourseController::class, 'focus'])->name('focus.index');
    Route::get('/calendar', [CourseController::class, 'calendar'])->name('calendar.index');
    
    // Pengaturan Profil (Bawaan Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // AI Study Assistant Chat
    Route::post('/ai/chat', [TaskController::class, 'aiChat'])->name('ai.chat');
});

// Rute Auth Breeze (Login, Register, Logout, dll)
require __DIR__.'/auth.php';
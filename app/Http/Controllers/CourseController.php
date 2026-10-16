<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Task;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        // Ambil semua matkul beserta relasi tugas-tugasnya
        $courses = Course::with('tasks')->get();
        return view('courses', compact('courses'));
    }

    public function calendar()
    {
        $courses = Course::all();
        $tasks = Task::with('course')->orderBy('due_date')->get();
        return view('calendar', compact('courses', 'tasks'));
    }

    public function focus()
    {
        $tasks = Task::where('status', '!=', 'done')->get();
        return view('focus', compact('tasks'));
    }
}
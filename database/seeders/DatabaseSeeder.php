<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Course;
use App\Models\Task;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat User Mahasiswa (Maya Kim)
        $user = User::create([
            'name' => 'Maya Kim',
            'email' => 'maya@studyflow.test',
            'password' => Hash::make('password123'),
        ]);

        // 2. Buat Data Mata Kuliah sesuai Figma
        $hci = Course::create([
            'user_id' => $user->id,
            'course_code' => 'HCI 302',
            'course_name' => 'Human-Computer Interaction',
            'lecturer_name' => 'Dr. Sarah Chen',
            'room' => 'Design Lab 204',
            'schedule_time' => 'Mon, Wed · 10:00-11:30',
            'credits' => 3,
            'color_hex' => '#8B5CF6', // Ungu
        ]);

        $cs = Course::create([
            'user_id' => $user->id,
            'course_code' => 'CS 241',
            'course_name' => 'Data Structures & Algorithms',
            'lecturer_name' => 'Prof. James Wilson',
            'room' => 'Engineering 112',
            'schedule_time' => 'Tue, Thu · 09:00-10:30',
            'credits' => 4,
            'color_hex' => '#3B82F6', // Biru
        ]);

        $math = Course::create([
            'user_id' => $user->id,
            'course_code' => 'MATH 221',
            'course_name' => 'Linear Algebra',
            'lecturer_name' => 'Dr. Emily Park',
            'room' => 'Science Hall 305',
            'schedule_time' => 'Mon, Wed · 13:00-14:30',
            'credits' => 3,
            'color_hex' => '#0EA5E9', // Biru Muda
        ]);

        $biol = Course::create([
            'user_id' => $user->id,
            'course_code' => 'BIOL 214',
            'course_name' => 'Cell & Molecular Biology',
            'lecturer_name' => 'Dr. Michael Rivera',
            'room' => 'Biology Lab 108',
            'schedule_time' => 'Tue, Fri · 14:00-15:30',
            'credits' => 4,
            'color_hex' => '#10B981', // Hijau
        ]);

        // 3. Buat Data Tugas Kanban sesuai Figma
        Task::create([
            'user_id' => $user->id,
            'course_id' => $hci->id,
            'title' => 'Submit HCI research plan',
            'description' => 'Research methods breakdown and target persona interviews',
            'due_date' => now()->toDateString(),
            'due_time' => '17:00:00',
            'priority' => 'high',
            'status' => 'todo',
        ]);

        Task::create([
            'user_id' => $user->id,
            'course_id' => $cs->id,
            'title' => 'Problem Set 6: Dynamic Programming',
            'description' => 'Complete 7 algorithm problems',
            'due_date' => now()->addDays(2)->toDateString(),
            'due_time' => '23:59:00',
            'priority' => 'medium',
            'status' => 'todo',
        ]);

        Task::create([
            'user_id' => $user->id,
            'course_id' => $math->id,
            'title' => 'Build midterm study guide',
            'description' => 'Matrices & eigenvalues summary sheet',
            'due_date' => now()->addDays(3)->toDateString(),
            'due_time' => '18:00:00',
            'priority' => 'medium',
            'status' => 'in_progress',
        ]);

        Task::create([
            'user_id' => $user->id,
            'course_id' => $hci->id,
            'title' => 'Peer review: Design critique',
            'description' => 'Feedback for Leo & Sam',
            'due_date' => now()->subDay()->toDateString(),
            'priority' => 'low',
            'status' => 'done',
        ]);
    }
}
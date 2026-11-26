<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Seed ten sample courses for each existing user.
     */
    public function run(): void
    {
        $courses = [
            [
                'name' => 'Web Development Fundamentals',
                'description' => 'Learn the foundations of HTML, CSS, and modern web development.',
                'duration' => 10,
                'fee' => 450.00,
                'difficulty' => 'Easy',
                'is_active' => true,
            ],
            [
                'name' => 'Python Programming',
                'description' => 'Build programming skills with Python fundamentals and practical exercises.',
                'duration' => 8,
                'fee' => 400.00,
                'difficulty' => 'Easy',
                'is_active' => true,
            ],
            [
                'name' => 'Database Design',
                'description' => 'Design relational databases and write effective SQL queries.',
                'duration' => 8,
                'fee' => 425.00,
                'difficulty' => 'Medium',
                'is_active' => true,
            ],
            [
                'name' => 'Cybersecurity Essentials',
                'description' => 'Explore security principles, common threats, and defensive practices.',
                'duration' => 10,
                'fee' => 500.00,
                'difficulty' => 'Medium',
                'is_active' => true,
            ],
            [
                'name' => 'Cloud Computing',
                'description' => 'Understand cloud infrastructure, deployment, and service models.',
                'duration' => 12,
                'fee' => 550.00,
                'difficulty' => 'Medium',
                'is_active' => true,
            ],
            [
                'name' => 'Data Analytics',
                'description' => 'Learn to prepare, analyse, and communicate insights from data.',
                'duration' => 10,
                'fee' => 475.00,
                'difficulty' => 'Medium',
                'is_active' => true,
            ],
            [
                'name' => 'Mobile App Development',
                'description' => 'Create mobile applications and learn core interface patterns.',
                'duration' => 12,
                'fee' => 575.00,
                'difficulty' => 'Hard',
                'is_active' => true,
            ],
            [
                'name' => 'Software Engineering',
                'description' => 'Practice software design, testing, version control, and teamwork.',
                'duration' => 12,
                'fee' => 600.00,
                'difficulty' => 'Hard',
                'is_active' => true,
            ],
            [
                'name' => 'Artificial Intelligence',
                'description' => 'Explore artificial intelligence concepts and introductory machine learning.',
                'duration' => 10,
                'fee' => 625.00,
                'difficulty' => 'Hard',
                'is_active' => true,
            ],
            [
                'name' => 'UI/UX Design',
                'description' => 'Develop user research, wireframing, and interface design skills.',
                'duration' => 8,
                'fee' => 375.00,
                'difficulty' => 'Easy',
                'is_active' => true,
            ],
        ];

        User::query()->each(function (User $user) use ($courses): void {
            foreach ($courses as $course) {
                $user->courses()->updateOrCreate(
                    ['name' => $course['name']],
                    $course
                );
            }
        });
    }
}

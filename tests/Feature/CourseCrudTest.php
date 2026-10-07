<?php

namespace Tests\Feature;

use App\Models\Course;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CourseCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_course_can_be_created_viewed_updated_and_deleted(): void
    {
        $courseData = [
            'name' => 'Web Development',
            'description' => 'An introduction to building websites.',
            'duration' => 12,
            'fee' => '450.00',
            'difficulty' => 'Medium',
            'is_active' => '1',
        ];

        $this->get(route('courses.index'))
            ->assertSee('No courses found.');

        $this->get(route('courses.create'))
            ->assertSee('Course name')
            ->assertSee('name="difficulty"', false);

        $response = $this->post(route('courses.store'), $courseData);

        $course = Course::query()->where('name', $courseData['name'])->firstOrFail();
        $response->assertRedirect(route('courses.show', $course));

        $this->assertDatabaseHas('courses', $courseData);

        $this->get(route('courses.show', $course))
            ->assertSee('Web Development')
            ->assertSee('An introduction to building websites.');

        $this->get(route('courses.index'))
            ->assertSee('Web Development');

        $this->get(route('courses.edit', $course))
            ->assertSee('value="Web Development"', false);

        $this->put(route('courses.update', $course), [
            ...$courseData,
            'name' => 'Advanced Web Development',
            'difficulty' => 'Hard',
            'is_active' => '0',
        ])->assertRedirect(route('courses.show', $course));

        $this->assertDatabaseHas('courses', [
            'id' => $course->id,
            'name' => 'Advanced Web Development',
            'difficulty' => 'Hard',
            'is_active' => false,
        ]);

        $this->delete(route('courses.destroy', $course))
            ->assertRedirect(route('courses.index'));

        $this->assertDatabaseMissing('courses', ['id' => $course->id]);
    }

    public function test_course_validation_rejects_an_unsupported_difficulty(): void
    {
        $this->from(route('courses.create'))
            ->post(route('courses.store'), [
                'name' => 'Test course',
                'description' => 'A course description.',
                'duration' => 4,
                'fee' => '100.00',
                'difficulty' => 'Expert',
                'is_active' => '1',
            ])
            ->assertRedirect(route('courses.create'))
            ->assertSessionHasErrors(['difficulty']);

        $this->assertDatabaseCount('courses', 0);
    }

    public function test_missing_course_returns_not_found(): void
    {
        $this->get(route('courses.show', 999999))->assertNotFound();
    }
}

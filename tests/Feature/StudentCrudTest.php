<?php

namespace Tests\Feature;

use App\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudentCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_student_can_be_created_viewed_updated_and_deleted(): void
    {
        $studentData = [
            'name' => 'Alex Morgan',
            'email' => 'alex@example.com',
            'phone' => '0123456789',
            'address' => '12 College Road',
            'date_of_birth' => '2002-04-15',
        ];

        $this->get(route('students.index'))
            ->assertSee('No students found.');

        $this->get(route('students.create'))
            ->assertSee('Date of birth')
            ->assertSee('name="name"', false);

        $response = $this->post(route('students.store'), $studentData);

        $student = Student::query()->where('email', $studentData['email'])->firstOrFail();
        $response->assertRedirect(route('students.show', $student));

        $this->assertDatabaseHas('students', [
            'id' => $student->id,
            'name' => $studentData['name'],
            'email' => $studentData['email'],
            'phone' => $studentData['phone'],
            'address' => $studentData['address'],
        ]);
        $this->assertSame('2002-04-15', $student->date_of_birth?->toDateString());

        $this->get(route('students.show', $student))
            ->assertSee('Alex Morgan')
            ->assertSee('12 College Road');

        $this->get(route('students.index'))
            ->assertSee('alex@example.com');

        $this->get(route('students.edit', $student))
            ->assertSee('value="Alex Morgan"', false);

        $this->put(route('students.update', $student), [
            ...$studentData,
            'name' => 'Alex Morgan Updated',
            'email' => 'alex.updated@example.com',
        ])->assertRedirect(route('students.show', $student));

        $this->assertDatabaseHas('students', [
            'id' => $student->id,
            'name' => 'Alex Morgan Updated',
            'email' => 'alex.updated@example.com',
        ]);

        $this->delete(route('students.destroy', $student))
            ->assertRedirect(route('students.index'));

        $this->assertDatabaseMissing('students', ['id' => $student->id]);
    }

    public function test_student_validation_errors_keep_old_input(): void
    {
        $this->from(route('students.create'))
            ->post(route('students.store'), [
                'name' => 'Sam Student',
                'email' => 'not-an-email',
                'phone' => '123',
            ])
            ->assertRedirect(route('students.create'))
            ->assertSessionHasErrors(['email'])
            ->assertSessionHasInput('name', 'Sam Student');

        $this->assertDatabaseCount('students', 0);
    }

    public function test_student_email_must_be_unique_when_updating_another_student(): void
    {
        $student = Student::factory()->create();
        $otherStudent = Student::factory()->create();

        $this->put(route('students.update', $otherStudent), [
            'name' => 'Updated Student',
            'email' => $student->email,
            'phone' => '0123456789',
            'address' => '',
            'date_of_birth' => '',
        ])->assertSessionHasErrors(['email']);

        $this->assertDatabaseHas('students', [
            'id' => $otherStudent->id,
            'email' => $otherStudent->email,
        ]);
    }

    public function test_missing_student_returns_not_found(): void
    {
        $this->get(route('students.show', 999999))->assertNotFound();
    }
}

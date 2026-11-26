<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\User;
use Database\Seeders\CourseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class Workshop4AuthorizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_from_protected_routes(): void
    {
        $this->get(route('courses.index'))->assertRedirect(route('login'));
        $this->get(route('students.index'))->assertRedirect(route('login'));
    }

    public function test_registration_creates_a_regular_user_and_logs_them_in(): void
    {
        $response = $this->post(route('register'), [
            'name' => 'Regular User',
            'email' => 'regular@example.com',
            'password' => 'Workshop@123',
            'password_confirmation' => 'Workshop@123',
            'role' => 'admin',
        ]);

        $response->assertRedirect(route('students.index'));

        $user = User::where('email', 'regular@example.com')->firstOrFail();
        $this->assertSame('user', $user->role);
        $this->assertAuthenticatedAs($user);
        $this->assertNotSame('Workshop@123', $user->password);
    }

    public function test_regular_user_cannot_access_another_users_course(): void
    {
        $owner = User::factory()->create(['role' => 'user']);
        $other = User::factory()->create(['role' => 'user']);
        $course = Course::factory()->create(['user_id' => $owner->id]);

        $this->actingAs($other);

        $this->get(route('courses.show', $course))->assertForbidden();
        $this->get(route('courses.edit', $course))->assertForbidden();
        $this->put(route('courses.update', $course), [
            'name' => 'Unauthorized',
            'description' => 'Should not be saved.',
            'duration' => 2,
            'fee' => '50.00',
            'difficulty' => 'Easy',
            'is_active' => '1',
        ])->assertForbidden();
        $this->delete(route('courses.destroy', $course))->assertForbidden();

        $this->assertDatabaseHas('courses', [
            'id' => $course->id,
            'name' => $course->name,
        ]);
    }

    public function test_course_list_isolated_and_admin_can_view_all_courses(): void
    {
        $owner = User::factory()->create(['role' => 'user']);
        $other = User::factory()->create(['role' => 'user']);
        $admin = User::factory()->create(['role' => 'admin']);
        $ownedCourse = Course::factory()->create([
            'name' => 'Owned course',
            'user_id' => $owner->id,
        ]);
        $otherCourse = Course::factory()->create([
            'name' => 'Other course',
            'user_id' => $other->id,
        ]);

        $this->actingAs($owner)
            ->get(route('courses.index'))
            ->assertSee('Regular user view')
            ->assertSee('Regular user')
            ->assertSee('Owned course')
            ->assertDontSee('Other course');

        $this->actingAs($admin)
            ->get(route('courses.index'))
            ->assertSee('Administrator view')
            ->assertSee('Administrator')
            ->assertSee($owner->name)
            ->assertSee('Owned course')
            ->assertSee('Other course');

        $this->actingAs($admin)
            ->get(route('courses.show', $ownedCourse))
            ->assertOk();
    }

    public function test_logging_out_and_back_in_switches_the_authenticated_role(): void
    {
        $regularUser = User::factory()->create(['role' => 'user']);
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($regularUser)
            ->get(route('courses.index'))
            ->assertSee('Regular user view');

        $this->post(route('logout'))->assertRedirect(route('login'));
        $this->assertGuest();

        $this->post(route('login'), [
            'email' => $admin->email,
            'password' => 'password',
        ])->assertRedirect(route('students.index'));
        $this->assertAuthenticatedAs($admin);

        $this->get(route('courses.index'))
            ->assertSee('Administrator view');
    }

    public function test_students_are_shared_between_regular_users(): void
    {
        $first = User::factory()->create(['role' => 'user']);
        $second = User::factory()->create(['role' => 'user']);

        $this->actingAs($first)
            ->post(route('students.store'), [
                'name' => 'Shared Student',
                'email' => 'shared@example.com',
                'phone' => '0123456789',
            ])
            ->assertRedirect();

        $this->actingAs($second)
            ->get(route('students.index'))
            ->assertSee('Shared Student');
    }

    public function test_course_seeder_creates_ten_owned_courses_per_user_without_duplicates(): void
    {
        $regularUser = User::factory()->create(['role' => 'user']);
        $admin = User::factory()->create(['role' => 'admin']);
        $seeder = new CourseSeeder;

        $seeder->run();
        $seeder->run();

        $this->assertSame(10, $regularUser->courses()->count());
        $this->assertSame(10, $admin->courses()->count());

        $this->actingAs($regularUser)
            ->get(route('courses.index'))
            ->assertSee('Web Development Fundamentals')
            ->assertDontSee('Owner');

        $this->actingAs($admin)
            ->get(route('courses.index'))
            ->assertSee('Web Development Fundamentals')
            ->assertSee('Owner');
    }
}

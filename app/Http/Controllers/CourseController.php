<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\In;
use Illuminate\View\View;

class CourseController extends Controller
{
    public function index(): View
    {
        return view('course.list', [
            'courses' => Course::query()->orderBy('name')->get(),
        ]);
    }

    public function create(): View
    {
        return view('course.create', ['course' => new Course(['is_active' => true])]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate($this->rules());

        $course = Course::create($validated);

        return Redirect::route('courses.show', $course)
            ->with('success', 'Course created successfully.');
    }

    public function show(int $id): View
    {
        return view('course.detail', [
            'course' => Course::findOrFail($id),
        ]);
    }

    public function edit(int $id): View
    {
        return view('course.edit', [
            'course' => Course::findOrFail($id),
        ]);
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $course = Course::findOrFail($id);
        $course->update($request->validate($this->rules()));

        return Redirect::route('courses.show', $course)
            ->with('success', 'Course updated successfully.');
    }

    public function destroy(int $id): RedirectResponse
    {
        Course::findOrFail($id)->delete();

        return Redirect::route('courses.index')
            ->with('success', 'Course deleted successfully.');
    }

    /**
     * Get the validation rules for course forms.
     *
     * @return array<string, array<int, string|In>>
     */
    private function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:2000'],
            'duration' => ['required', 'integer', 'min:1'],
            'fee' => ['required', 'decimal:0,2', 'min:0'],
            'difficulty' => ['required', Rule::in(['Easy', 'Medium', 'Hard'])],
            'is_active' => ['required', 'boolean'],
        ];
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class StudentController extends Controller
{
    public function index(): View
    {
        return view('student.list', [
            'students' => Student::query()->orderBy('name')->get(),
        ]);
    }

    public function create(): View
    {
        return view('student.create', ['student' => new Student]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('students', 'email')],
            'phone' => ['required', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:500'],
            'date_of_birth' => ['nullable', 'date'],
        ]);

        $student = Student::create($validated);

        return Redirect::route('students.show', $student)
            ->with('success', 'Student created successfully.');
    }

    public function show(int $id): View
    {
        return view('student.detail', [
            'student' => Student::findOrFail($id),
        ]);
    }

    public function edit(int $id): View
    {
        return view('student.edit', [
            'student' => Student::findOrFail($id),
        ]);
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $student = Student::findOrFail($id);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('students', 'email')->ignore($student->id)],
            'phone' => ['required', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:500'],
            'date_of_birth' => ['nullable', 'date'],
        ]);

        $student->update($validated);

        return Redirect::route('students.show', $student)
            ->with('success', 'Student updated successfully.');
    }

    public function destroy(int $id): RedirectResponse
    {
        Student::findOrFail($id)->delete();

        return Redirect::route('students.index')
            ->with('success', 'Student deleted successfully.');
    }
}

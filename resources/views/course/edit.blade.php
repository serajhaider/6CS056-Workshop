@extends('layouts.app')

@section('title', 'Edit course')

@section('content')
    <h1>Edit course</h1>
    <p class="muted">Update the details for {{ $course->name }}.</p>

    @include('course.form', [
        'action' => route('courses.update', $course),
        'method' => 'PUT',
    ])
@endsection

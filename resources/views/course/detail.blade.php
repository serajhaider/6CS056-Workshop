@extends('layouts.app')

@section('title', 'Course details')

@section('content')
    <div class="page-heading">
        <div>
            <h1>Course details</h1>
            <p class="muted">Course record #{{ $course->id }}</p>
        </div>
        <a class="button" href="{{ route('courses.edit', $course) }}">Edit course</a>
    </div>

    <dl class="details">
        <dt>Name</dt>
        <dd>{{ $course->name }}</dd>
        <dt>Description</dt>
        <dd class="preserve-lines">{{ $course->description }}</dd>
        <dt>Duration</dt>
        <dd>{{ $course->duration }} weeks</dd>
        <dt>Fee</dt>
        <dd>{{ number_format((float) $course->fee, 2) }}</dd>
        <dt>Difficulty</dt>
        <dd>{{ $course->difficulty }}</dd>
        <dt>Status</dt>
        <dd>{{ $course->is_active ? 'Active' : 'Inactive' }}</dd>
    </dl>

    <a class="button button-secondary" href="{{ route('courses.index') }}">Back to courses</a>
@endsection

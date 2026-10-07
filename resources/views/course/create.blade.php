@extends('layouts.app')

@section('title', 'Add course')

@section('content')
    <h1>Add course</h1>
    <p class="muted">Enter the course details below.</p>

    @include('course.form', [
        'action' => route('courses.store'),
        'method' => 'POST',
    ])
@endsection

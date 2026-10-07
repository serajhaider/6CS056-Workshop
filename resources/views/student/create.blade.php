@extends('layouts.app')

@section('title', 'Add student')

@section('content')
    <h1>Add student</h1>
    <p class="muted">Enter the student's details below.</p>

    @include('student.form', [
        'action' => route('students.store'),
        'method' => 'POST',
    ])
@endsection

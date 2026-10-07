@extends('layouts.app')

@section('title', 'Edit student')

@section('content')
    <h1>Edit student</h1>
    <p class="muted">Update the details for {{ $student->name }}.</p>

    @include('student.form', [
        'action' => route('students.update', $student),
        'method' => 'PUT',
    ])
@endsection

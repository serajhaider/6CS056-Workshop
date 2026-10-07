@extends('layouts.app')

@section('title', 'Student details')

@section('content')
    <div class="page-heading">
        <div>
            <h1>Student details</h1>
            <p class="muted">Student record #{{ $student->id }}</p>
        </div>
        <a class="button" href="{{ route('students.edit', $student) }}">Edit student</a>
    </div>

    <dl class="details">
        <dt>Name</dt>
        <dd>{{ $student->name }}</dd>
        <dt>Email</dt>
        <dd>{{ $student->email }}</dd>
        <dt>Phone</dt>
        <dd>{{ $student->phone }}</dd>
        <dt>Address</dt>
        <dd class="preserve-lines">{{ $student->address ?: 'Not provided' }}</dd>
        <dt>Date of birth</dt>
        <dd>{{ $student->date_of_birth?->format('d M Y') ?? 'Not provided' }}</dd>
    </dl>

    <a class="button button-secondary" href="{{ route('students.index') }}">Back to students</a>
@endsection

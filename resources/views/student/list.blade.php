@extends('layouts.app')

@section('title', 'Students')

@section('content')
    <div class="page-heading">
        <div>
            <h1>Students</h1>
            <p class="muted">View and manage student records.</p>
        </div>
        <a class="button" href="{{ route('students.create') }}">Add student</a>
    </div>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Phone</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($students as $student)
                    <tr>
                        <td>{{ $student->id }}</td>
                        <td>{{ $student->name }}</td>
                        <td>{{ $student->email }}</td>
                        <td>{{ $student->phone }}</td>
                        <td>
                            <div class="actions">
                                <a href="{{ route('students.show', $student) }}">View</a>
                                <a href="{{ route('students.edit', $student) }}">Edit</a>
                                <form action="{{ route('students.destroy', $student) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="link-button" type="submit">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="empty-state">No students found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection

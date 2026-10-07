@extends('layouts.app')

@section('title', 'Courses')

@section('content')
    <div class="page-heading">
        <div>
            <h1>Courses</h1>
            <p class="muted">View and manage course records.</p>
        </div>
        <a class="button" href="{{ route('courses.create') }}">Add course</a>
    </div>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Duration</th>
                    <th scope="col">Fee</th>
                    <th scope="col">Difficulty</th>
                    <th scope="col">Status</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($courses as $course)
                    <tr>
                        <td>{{ $course->id }}</td>
                        <td>{{ $course->name }}</td>
                        <td>{{ $course->duration }} weeks</td>
                        <td>{{ number_format((float) $course->fee, 2) }}</td>
                        <td>{{ $course->difficulty }}</td>
                        <td>{{ $course->is_active ? 'Active' : 'Inactive' }}</td>
                        <td>
                            <div class="actions">
                                <a href="{{ route('courses.show', $course) }}">View</a>
                                <a href="{{ route('courses.edit', $course) }}">Edit</a>
                                <form action="{{ route('courses.destroy', $course) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="link-button" type="submit">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="empty-state">No courses found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection

@extends('layouts.app')

@section('title', 'Courses')

@section('content')
    <div class="page-heading">
        <div>
            <h1>Courses</h1>
            @if (auth()->user()->role === 'admin')
                <p class="muted">Administrator view: all users' courses are shown, and you can manage any course.</p>
            @else
                <p class="muted">Regular user view: only your courses are shown. You can manage your own courses, not another user's.</p>
            @endif
        </div>
        <a class="button" href="{{ route('courses.create') }}">Add course</a>
    </div>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    @if (auth()->user()->role === 'admin')
                        <th scope="col">Owner</th>
                    @endif
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
                        @if (auth()->user()->role === 'admin')
                            <td>{{ $course->user->name }}</td>
                        @endif
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
                        <td colspan="{{ auth()->user()->role === 'admin' ? 8 : 7 }}" class="empty-state">
                            No {{ auth()->user()->role === 'admin' ? 'courses exist' : 'courses belong to you yet' }}.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection

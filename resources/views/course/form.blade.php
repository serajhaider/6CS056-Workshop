@php($course ??= new \App\Models\Course())

@if ($errors->any())
    <div class="notice notice-error" role="alert">
        <p>Please correct the following errors:</p>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form class="form-panel" action="{{ $action }}" method="POST">
    @csrf
    @if ($method !== 'POST')
        @method($method)
    @endif

    <div class="form-field">
        <label for="name">Course name</label>
        <input id="name" name="name" type="text" value="{{ old('name', $course->name) }}" required maxlength="255">
    </div>

    <div class="form-field">
        <label for="description">Description</label>
        <textarea id="description" name="description" rows="4" required maxlength="2000">{{ old('description', $course->description) }}</textarea>
    </div>

    <div class="form-field">
        <label for="duration">Duration (weeks)</label>
        <input id="duration" name="duration" type="number" min="1" step="1" value="{{ old('duration', $course->duration) }}" required>
    </div>

    <div class="form-field">
        <label for="fee">Fee</label>
        <input id="fee" name="fee" type="number" min="0" step="0.01" value="{{ old('fee', $course->fee) }}" required>
    </div>

    <div class="form-field">
        <label for="difficulty">Difficulty</label>
        <select id="difficulty" name="difficulty" required>
            <option value="">Select difficulty</option>
            @foreach (['Easy', 'Medium', 'Hard'] as $difficulty)
                <option value="{{ $difficulty }}" @selected(old('difficulty', $course->difficulty) === $difficulty)>
                    {{ $difficulty }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-field checkbox-field">
        <input type="hidden" name="is_active" value="0">
        <input id="is_active" name="is_active" type="checkbox" value="1" @checked((bool) old('is_active', $course->is_active))>
        <label for="is_active">Course is active</label>
    </div>

    <div class="form-actions">
        <button class="button" type="submit">{{ $method === 'POST' ? 'Create course' : 'Save changes' }}</button>
        <a class="button button-secondary" href="{{ route('courses.index') }}">Cancel</a>
    </div>
</form>

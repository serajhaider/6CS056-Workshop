@php($student ??= new \App\Models\Student())

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
        <label for="name">Name</label>
        <input id="name" name="name" type="text" value="{{ old('name', $student->name) }}" required maxlength="255">
    </div>

    <div class="form-field">
        <label for="email">Email</label>
        <input id="email" name="email" type="email" value="{{ old('email', $student->email) }}" required maxlength="255">
    </div>

    <div class="form-field">
        <label for="phone">Phone</label>
        <input id="phone" name="phone" type="text" value="{{ old('phone', $student->phone) }}" required maxlength="20">
    </div>

    <div class="form-field">
        <label for="address">Address <span class="muted">(optional)</span></label>
        <textarea id="address" name="address" rows="3" maxlength="500">{{ old('address', $student->address) }}</textarea>
    </div>

    <div class="form-field">
        <label for="date_of_birth">Date of birth <span class="muted">(optional)</span></label>
        <input
            id="date_of_birth"
            name="date_of_birth"
            type="date"
            value="{{ old('date_of_birth', $student->date_of_birth?->format('Y-m-d')) }}"
        >
    </div>

    <div class="form-actions">
        <button class="button" type="submit">{{ $method === 'POST' ? 'Create student' : 'Save changes' }}</button>
        <a class="button button-secondary" href="{{ route('students.index') }}">Cancel</a>
    </div>
</form>

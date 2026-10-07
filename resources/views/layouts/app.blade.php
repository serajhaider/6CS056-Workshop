<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Training Institute') | Workshop 1</title>
    @vite('resources/css/app.css')
</head>
<body>
    <header class="site-header">
        <div class="container header-content">
            <a class="site-title" href="{{ route('students.index') }}">Training Institute</a>
            <nav aria-label="Main navigation">
                <a href="{{ route('students.index') }}">Students</a>
                <a href="{{ route('courses.index') }}">Courses</a>
            </nav>
        </div>
    </header>

    <main class="container page-content">
        @if (session('success'))
            <p class="notice notice-success" role="status">{{ session('success') }}</p>
        @endif

        @yield('content')
    </main>

    <footer class="site-footer">
        <div class="container">6CS056 Workshop 1</div>
    </footer>
</body>
</html>

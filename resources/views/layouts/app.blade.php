<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Training Institute') | Workshop 4</title>
    @vite('resources/css/app.css')
</head>
<body>
    @include('components.navbar')

    <main class="container page-content">
        @if (session('success'))
            <p class="notice notice-success" role="status">{{ session('success') }}</p>
        @endif
        @if (session('error'))
            <p class="notice notice-error" role="alert">{{ session('error') }}</p>
        @endif

        @yield('content')
    </main>

    @include('components.footer')
</body>
</html>

<header class="site-header">
    <div class="container header-content">
        <a class="site-title" href="{{ auth()->check() ? route('students.index') : route('login') }}" aria-label="Seraj home">
            <span class="brand-mark" aria-hidden="true">S</span>
            <span>Seraj</span>
        </a>
        <nav aria-label="Main navigation">
            @auth
                <a class="{{ request()->routeIs('students.*') ? 'active' : '' }}" href="{{ route('students.index') }}">Students</a>
                <a class="{{ request()->routeIs('courses.*') ? 'active' : '' }}" href="{{ route('courses.index') }}">Courses</a>
                @php
                    $userNameParts = collect(preg_split('/\s+/', trim(auth()->user()->name)))->filter();
                    $userInitials = $userNameParts->take(2)
                        ->map(fn ($part) => mb_strtoupper(mb_substr($part, 0, 1)))
                        ->implode('');
                @endphp
                <span class="account-chip" aria-label="Signed in as {{ auth()->user()->name }}">
                    <span class="account-avatar" aria-hidden="true">{{ $userInitials }}</span>
                    <span class="account-details">
                        <span class="account-name">{{ auth()->user()->name }}</span>
                        <span class="role-badge role-badge-{{ auth()->user()->role }}">
                            {{ auth()->user()->role === 'admin' ? 'Administrator' : 'Regular user' }}
                        </span>
                    </span>
                </span>
                <form class="logout-form" method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="button button-logout" type="submit">Logout</button>
                </form>
            @endauth
            @guest
                <a href="{{ route('register') }}">Register</a>
                <a href="{{ route('login') }}">Login</a>
            @endguest
        </nav>
    </div>
</header>

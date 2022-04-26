<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <h2 class="navbar-brand">{{ $activePage }}</h2>
    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
            <a class="nav-link" href="#" data-toggle="dropdown" aria-expanded="false">
                <span class="oi oi-person"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <p class="dropdown-item">{{ \Auth::user()->getAttribute('user_id') }}</p>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{ route('admin.auth.logout') }}" >
                    <span class="oi oi-account-logout"></span> logout
                </a>
            </div>
        </li>
    </ul>
</nav>

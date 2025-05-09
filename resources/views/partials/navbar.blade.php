<nav class="navbar navbar-expand-lg navbar-dark bg-warning">
    <div class="container">
        <a class="navbar-brand fw-bold d-flex align-items-center" href="{{ route('home') }}">
            <div class="logo-tamano">
                <img class="logo" src="{{ asset('img/logo.png') }}" alt="Logo">
            </div>
            <span class="text-black fs-1">Erasvibes</span>
        </a>

        <div class="d-flex align-items-center">
            <a href="{{ route('search') }}" class="text-black mx-3">
                <i class="bi bi-search-heart-fill fs-3"></i>
            </a>

            @auth
                <a href="{{ route('messages.index') }}" class="text-black mx-3">
                    <i class="bi bi-chat-dots-fill fs-3"></i>
                </a>
                <a href="{{ route('friends.index') }}" class="text-black mx-3">
                    <i class="bi bi-people-fill fs-3"></i>
                </a>
            @else
                <a href="{{ route('login') }}" class="text-black mx-3">
                    <i class="bi bi-chat-dots-fill fs-3"></i>
                </a>
                <a href="{{ route('login') }}" class="text-black mx-3">
                    <i class="bi bi-people-fill fs-3"></i>
                </a>
            @endauth

            @auth
                <div class="dropdown">
                    <a href="#" class="text-black mx-3 dropdown-toggle" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-circle fs-3"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <li><a class="dropdown-item" href="{{ route('perfil') }}">Ver Perfil</a></li>
                        @if (auth()->user()->is_admin)
                            <li><a class="dropdown-item" href="{{ route('admin.index') }}">Panel de administrador</a></li>
                        @endif
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item">Cerrar sesión</button>
                            </form>
                        </li>
                    </ul>
                </div>
            @else
                <a href="{{ route('login') }}" class="text-black mx-3">
                    <i class="bi bi-person-circle fs-3"></i>
                </a>
            @endauth
        </div>
    </div>
</nav>

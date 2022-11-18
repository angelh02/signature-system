<div class="navbar-custom">
    <ul class="list-unstyled topbar-menu float-end mb-0">

        <li class="dropdown notification-list">
            <a class="nav-link dropdown-toggle nav-user arrow-none me-0" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                <span class="account-user-avatar">
                    {{-- <img src="{{ asset('css/images/user-avatar.png') }}" alt="user-image" class="rounded-circle"> --}}
                </span>
                <span>
                    <span class="account-user-name">{{ Auth::user()->name }}</span>
                    {{-- <span class="account-position">{{ Auth::user()->department['name'] }}</span> --}}
                </span>
            </a>
            <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated topbar-dropdown-menu profile-dropdown">

                <!-- item-->
                @if(false)
                <a href="{{ route('reset-password') }}" class="dropdown-item notify-item">
                    <i class="mdi mdi-account-key me-1"></i>
                    <span>Cambiar de Contraseña</span>
                </a>
                @endif
                <!-- item-->
                <a class="dropdown-item notify-item" href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                >
                    <i class="mdi mdi-logout me-1"></i>
                    <span>{{ __('Cerrar sesión') }}</span>
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </li>

    </ul>
    <button class="button-menu-mobile open-left">
        <i class="mdi mdi-menu"></i>
    </button>



</div>
<!-- end Topbar -->

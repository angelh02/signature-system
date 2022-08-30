<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm fixed-top">
    <div class="container-fluid">
        <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <span class="account-user-avatar">
            <img src="{{ asset('css/images/EFIRMA.png') }}" alt="user-image" class="rounded-circle">
        </span>
        <div class="col nav">
            <ul class="nav nav-tabs nav-bordered navbar-collapse collapse" id="navbarSupportedContent">
                <li class="nav-item " >
                        <router-link class="nav-link py-2 text-body" active-class="active" to="/documents">
                            <h4>MIS DOCUMENTOS</h2>
                        </router-link>
                </li>
                <li class="nav-item" >
                        <router-link class="nav-link py-2 text-body" active-class="active" to="/fileclasification">
                            <h4>CLASIFICACIÓN DE ARCHIVOS</h4>
                        </router-link>
                </li>
                <li class="nav-item" >
                        <router-link class="nav-link py-2 text-body" active-class="active" to="/containers">
                            <h4>CONTENEDORES</h4>
                        </router-link>
                </li>
            </ul>
        </div>  
        <div class="" style="">       
        <ul class="navbar-nav me-auto mb-2 mb-lg-0 w-100">     
            <li class="dropdown notification-list">
                <a class="nav-link dropdown-toggle nav-user arrow-none me-0" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                    <span class="account-user-avatar">
                        <img src="{{ asset('css/images/user-avatar.png') }}" alt="user-image" class="rounded-circle">
                    </span>
                    <span>
                        <span class="account-user-name mt-1">{{ Auth::user()->name }}</span>
                        {{-- <span class="account-position">{{ Auth::user()->department['name'] }}</span> --}}
                    </span>
                </a>
            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-animated topbar-dropdown-menu profile-dropdown" aria-labelledby="navbarDropdown">
                <a class="dropdown-item notify-item" href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                >
                    <i class="mdi mdi-logout me-1"></i>
                    <span>{{ __('Cerrar sesión') }}</span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </ul>
            </li>
            
        </ul>
        
        </div>
    </div>
</nav>
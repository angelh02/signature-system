<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm fixed-top">
    <div class="container-fluid">
        <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <span class="account-user-avatar mx-auto">
            <img src="{{ asset('/images/itsl-logo.png') }}" style="width: 65px; height: 65px" alt="user-image" class="rounded-circle me-2">
        </span>
        <div class="nav col">
            <ul class="nav nav-tabs nav-bordered navbar-collapse collapse" id="navbarSupportedContent">
                <div class="col-9 col-sm-auto col-md-auto col-lg-auto col-xl-auto">
                    <li class="nav-item" >
                        <router-link class="nav-link py-2 text-body" active-class="active" to="/usuarios">
                            <h5>USUARIOS</h5>
                        </router-link>
                    </li>
                </div>
                <div class="col-9 col-sm-auto col-md-auto col-lg-auto col-xl-auto">
                    <li class="nav-item" >
                        <router-link class="nav-link py-2 text-body" active-class="active" to="/solicitudes">
                            <h5>SOLICITUDES</h5>
                        </router-link>
                    </li>
                </div>
                <div class="col-9 col-sm-auto col-md-auto col-lg-auto col-xl-auto">
                    <li class="nav-item" >
                        <router-link class="nav-link py-2 text-body" active-class="active" to="/catalogo/tipos-documentos">
                            <h5>TIPOS DE DOCUMENTOS</h5>
                        </router-link>
                    </li>
                </div>
                <div class="col-9 col-sm-auto col-md-auto col-lg-auto col-xl-auto">
                    <li class="nav-item" >
                        <div class="dropdown">
                            <a class="nav-link py-2 text-body" active-class="active" to="#" id="clasification" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <h5 class="dropdown-toggle">CATÁLOGOS DE CLASIFICACIÓN</h5>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="clasification">
                                <router-link class="text-body btn-online-ligth dropdown-item" active-class="active" to="/catalogo/fondos">
                                    <h5>Fondos</h5>
                                </router-link>
                                <router-link class="text-body btn-online-ligth dropdown-item" active-class="active" to="/catalogo/secciones">
                                    <h5>Secciones</h5>
                                </router-link>
                                <router-link class="text-body btn-online-ligth dropdown-item" active-class="active" to="/catalogo/areas-productoras">
                                    <h5>Aréas productoras</h5>
                                </router-link>
                            </div>
                        </div>
                    </li>
                </div>
                <div class="col-9 col-sm-auto col-md-auto col-lg-auto col-xl-auto">
                    <li class="nav-item" >
                        <div class="dropdown">
                            <a class="nav-link py-2 text-body" active-class="active" to="#" id="containers" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <h5 class="dropdown-toggle">CATÁLOGOS DE CONTENEDORES</h5>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="containers">
                                <router-link class="text-body btn-online-ligth dropdown-item" active-class="active" to="/catalogo/tiempos-conservacion">
                                    <h5>Tiempos de conservación</h5>
                                </router-link>
                                <router-link class="text-body btn-online-ligth dropdown-item" active-class="active" to="/catalogo/tipos-conservacion">
                                    <h5>Tipos de conservación</h5>
                                </router-link>
                                <router-link class="text-body btn-online-ligth dropdown-item" active-class="active" to="/catalogo/valores-documentales">
                                    <h5>Valores documentales</h5>
                                </router-link>
                                <router-link class="text-body btn-online-ligth dropdown-item" active-class="active" to="/catalogo/tipos-informacion">
                                    <h5>Tipos de información</h5>
                                </router-link>
                                <router-link class="text-body btn-online-ligth dropdown-item" active-class="active" to="/catalogo/tecnicas-seleccion">
                                    <h5>Técnicas de selección</h5>
                                </router-link>
                            </div>
                        </div>
                    </li>
                </div>
            </ul>
        </div>  
        <div class="" style="">       
        <ul class="navbar-nav me-auto mb-2 mb-lg-0 w-100 fe">     
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
            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-animated topbar-dropdown-menu profile-dropdown fer" aria-labelledby="navbarDropdown">
                @if(false)
                <a href="{{ route('reset-password') }}" class="dropdown-item notify-item">
                    <i class="mdi mdi-account-key me-1"></i>
                    <span>Cambiar de Contraseña</span>
                </a>
                @endif
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

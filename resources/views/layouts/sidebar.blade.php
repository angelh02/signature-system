<div class="leftside-menu">

    <!-- LOGO -->
    <a href="#" class="logo text-center logo-light">
        <span class="logo-lg">
            {{-- <img src="{{ asset('css/images/ITS-Lerdo.png') }}" alt="" height="16"> --}}
        </span>
        <span class="logo-sm">
            <img src="" alt="" height="16">
        </span>
    </a>

    <!-- LOGO -->
    <a to="#" class="logo text-center logo-dark">
        <span class="logo-lg">
            <img src="" alt="" height="16">
        </span>
        <span class="logo-sm">
            Logo
            <img src="" alt="" height="16">
        </span>
    </a>

    <div class="h-100" id="leftside-menu-container" data-simplebar>

        <!--- Sidemenu -->
        <ul class="side-nav">
            <li class="side-nav-title side-nav-item">Navegación</li>
            <li class="side-nav-item">
                <a href="/" class="side-nav-link">
                    <i class="uil-th"></i>
                    <span>Cuadro de Mando</span>
                </a>
            </li>

            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarTitulacion" aria-expanded="false" aria-controls="sidebarTitulacion" class="side-nav-link">
                    <i class="uil-graduation-hat"></i>
                    <span> Titulación </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarTitulacion">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="/study-plans">Planes de Estudio</a>
                        </li>
                        <li>
                            <a href="/degree-modalities">Modalidades</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarSolicitudes" aria-expanded="false" aria-controls="sidebarSolicitudes" class="side-nav-link">
                    <i class="uil-envelope"></i>
                    <span> Solicitudes </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarSolicitudes">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="/degree-process-register">Registro</a>
                        </li>
                        <li>
                            <a href="/degree-process-progress">Seguimiento</a>
                        </li>
                        {{-- <li>
                            <a href="/protocol-acts">Actos Protocolarios</a>
                        </li> --}}
                    </ul>
                </div>
            </li>
        </ul>
        <!-- End Sidebar -->
        <div class="clearfix"></div>
    </div>

</div>
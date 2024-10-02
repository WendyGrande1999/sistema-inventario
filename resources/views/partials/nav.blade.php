<!-- resources/views/layouts/navbar.blade.php -->
<nav class=" navbar navbar-expand-sm navbar-dark bg-dark menu-horizontal col-md-6 col-sm-12" >
    <!-- Navbar Brand-->
    <a class="navbar-brand ps-5 alinear-texto" href="/home" >SI Hojas Eco Villas</a>
    <!-- Sidebar Toggle-->

    <!-- Navbar-->
    <ul class="navbar-nav ms-auto">
        <!-- Otras opciones de navegación -->

        <!-- Perfil del Usuario -->
        @auth
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">

            <i class="bi bi-person me-2"></i>

                {{ Auth::user()->name }}
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                <li>
                    <a class="dropdown-item" href="{{ route('profile.show') }}">
                    </i> Mi Perfil
                    </a>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="bi bi-box-arrow-right me-2"></i> Cerrar Sesión
                    </a>
                </li>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </ul>
        </li>
        @endauth

        <!-- Opción para iniciar sesión si no está autenticado -->
        @guest
        <li class="nav-item">
            <a class="nav-link" href="{{ route('login') }}">Iniciar Sesión</a>
        </li>
        @endguest
    </ul>
</nav>

<div class="d-flex align-items-center justify-content-between">
    <a href="index.html" class="logo d-flex align-items-center">
        <img src="assets/img/logo.png" alt="">
        <span class="d-none d-lg-block">Sistema de Inventario</span>
    </a>
    <i class="bi bi-list toggle-sidebar-btn"></i>
</div><!-- End Logo -->

<!-- ======= Buscador ======= -->
<div class="search-bar">
    <form class="search-form d-flex align-items-center" method="POST" action="#">
        <input type="text" name="query" placeholder="Search" title="Enter search keyword">
        <button type="submit" title="Search"><i class="bi bi-search"></i></button>
    </form>
</div><!-- End Search Bar -->


<nav class="header-nav ms-auto">

    <ul class="d-flex align-items-center">

        <li class="nav-item d-block d-lg-none">
            <a class="nav-link nav-icon search-bar-toggle " href="#">
                <i class="bi bi-search"></i>
            </a>
        </li><!-- End Search Icon-->

        <li class="nav-item dropdown">

            <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
                <i class="bi bi-bell"></i>
                <span class="badge bg-primary badge-number">{{ $productosPorAgotarse }}</span>
            </a><!-- End Notification Icon -->

            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
                <li class="dropdown-header">
                    Tiene {{ $productosPorAgotarse }} nuevas notificaciones
                    <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">Nuevas</span></a>
                </li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                @foreach ($dataProductos as $producto)
                @if ($producto['stockTotalActual'] <= 15)
                <li class="notification-item">
                    <i class="bi bi-exclamation-circle text-warning"></i>
                    <div >
                        <h4> <td>{{ $producto['nombre'] }}</h4>
                        <p>{{ $producto['stockTotalActual'] }}</p>
                        <p>{{ $producto['unidad_medida'] }}es</p>
                    </div>
                </li>
                @endif

                @endforeach
                <li>
                    <hr class="dropdown-divider">
                </li>

                <li class="dropdown-footer">
                    <a href="/inventario/stock">Ver mas notificaciones</a>
                </li>


            </ul><!-- End Notification Dropdown Items -->

        </li><!-- End Notification Nav -->



        @auth
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                    data-bs-toggle="dropdown" aria-expanded="false">

                    <i class="bi bi-person me-2"></i>

                    {{ Auth::user()->name }}
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li>
                        <a class="dropdown-item" href="{{ route('profile.show') }}">
                            </i> Mi Perfil
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
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
</nav><!-- End Icons Navigation -->

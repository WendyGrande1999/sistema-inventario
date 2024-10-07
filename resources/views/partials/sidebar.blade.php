<ul class="sidebar-nav" id="sidebar-nav">
    @role('admin')
        <li class="nav-item">
            <a class="nav-link " href="/home">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li><!-- End Dashboard Nav -->
        <li class="nav-heading">Pages</li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="/admin/users">
                <i class="bi bi-person"></i>
                <span>Gestion de usuarios</span>
            </a>
        </li><!-- End Profile Page Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="/categories">
                <i class="bi bi-tags me-2"></i>
                <span>Categorias</span>
            </a>
        </li><!-- End F.A.Q Page Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('suppliers.index') }}">
                <i class="bi bi-truck me-2"></i>
                <span>Proveedores</span>
            </a>
        </li><!-- End Contact Page Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('productos.index') }}">
                <i class="bi bi-box-seam me-2"></i>
                <span>Productos</span>
            </a>
        </li><!-- End Register Page Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="/inventario/stock">
                <i class="bi bi-boxes me-2"></i>
                <span>Stock</span>
            </a>
        </li><!-- End Login Page Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-cart-check me-2"></i><span>Gestion de existencias</span><i
                    class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="forms-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('entradas.index') }}">
                        <i class="bi bi-circle"></i><span>Entradas</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('salidas.index') }}">
                        <i class="bi bi-circle"></i><span>Salidas</span>
                    </a>
                </li>
            </ul>
        </li><!-- End Forms Nav -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#">
                <i class="bi bi-graph-up me-2"></i>
                <span>Reportes</span>
            </a>
        </li><!-- End Login Page Nav -->
    @endrole

    @role('escritor')
    <li class="nav-item">
        <a class="nav-link " href="/home">
            <i class="bi bi-grid"></i>
            <span>Dashboard</span>
        </a>
    </li><!-- End Dashboard Nav -->

    <li class="nav-item">
        <a class="nav-link collapsed" href="/categories">
            <i class="bi bi-tags me-2"></i>
            <span>Categorias</span>
        </a>
    </li><!-- End F.A.Q Page Nav -->

    <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('suppliers.index') }}">
            <i class="bi bi-truck me-2"></i>
            <span>Proveedores</span>
        </a>
    </li><!-- End Contact Page Nav -->

    <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('productos.index') }}">
            <i class="bi bi-box-seam me-2"></i>
            <span>Productos</span>
        </a>
    </li><!-- End Register Page Nav -->

    <li class="nav-item">
        <a class="nav-link collapsed" href="/inventario/stock">
            <i class="bi bi-boxes me-2"></i>
            <span>Stock</span>
        </a>
    </li><!-- End Login Page Nav -->

    <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
            <i class="bi bi-cart-check me-2"></i><span>Gestion de existencias</span><i
                class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="forms-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
            <li>
                <a href="{{ route('entradas.index') }}">
                    <i class="bi bi-circle"></i><span>Entradas</span>
                </a>
            </li>
            <li>
                <a href="{{ route('salidas.index') }}">
                    <i class="bi bi-circle"></i><span>Salidas</span>
                </a>
            </li>
        </ul>
    </li><!-- End Forms Nav -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#">
            <i class="bi bi-graph-up me-2"></i>
            <span>Reportes</span>
        </a>
    </li><!-- End Login Page Nav -->
@endrole
</ul>

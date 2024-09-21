<!-- resources/views/partials/sidebar.blade.php -->
<nav class="sidebar bg-dark vh-100">
    <ul class="nav flex-column">
        <br>
        <li class="nav-item">
            <a href="/inventory/products" class="nav-link text-white d-flex">
                <i class="bi bi-list me-2"></i>
                <span>MENÚ</span>
            </a>
        </li>
        <br>
        <br>

        <li class="nav-item">
            <a href="/home" class="nav-link text-white d-flex">
                <i class="bi bi-house me-2"></i>
                <span>Inicio</span>
            </a>
        </li>
        @role('admin')
      
      
        <li class="nav-item">
            <a href="/admin/users" class="nav-link text-white d-flex align-items-center">
                <i class="bi bi-person me-2"></i>
                <span>Gestión de usuarios</span>
            </a>
        </li>
       
        <li class="nav-item">
            <a href="/categories" class="nav-link text-white d-flex align-items-center">
                <i class="bi bi-tags me-2"></i>
                <span>Categorías</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('suppliers.index') }}" class="nav-link text-white d-flex align-items-center">
                <i class="bi bi-truck me-2"></i>
                <span>Proveedores</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('productos.index') }}" class="nav-link text-white d-flex">
                <i class="bi bi-box-seam me-2"></i>
                <span>Productos</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="/inventory/stock" class="nav-link text-white d-flex align-items-center">
                <i class="bi bi-boxes me-2"></i>
                <span>Stock</span>
            </a>
        </li>

        <!-- Gestión de existencias con submenú -->
        <li class="nav-item">
            <a class="nav-link text-white d-flex align-items-center" data-bs-toggle="collapse" href="#stockSubmenu" role="button" aria-expanded="false" aria-controls="stockSubmenu">
                <i class="bi bi-cart-check me-2"></i>
                <span>Gestión de existencias</span>
                <i class="bi bi-chevron-down ms-auto"></i> <!-- Indicador de colapso -->
            </a>
            <ul class="collapse list-unstyled ps-3" id="stockSubmenu">
                <li class="nav-item">
                    <a href="{{ route('entradas.index') }}" class="nav-link text-white d-flex align-items-center">
                        <i class="bi bi-box-arrow-in-right me-2"></i>
                        <span>Entradas</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/inventory/stock/exits" class="nav-link text-white d-flex align-items-center">
                        <i class="bi bi-box-arrow-right me-2"></i>
                        <span>Salidas</span>
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-item">
            <a href="/inventory/reports" class="nav-link text-white d-flex align-items-center">
                <i class="bi bi-graph-up me-2"></i>
                <span>Reportes</span>
            </a>
        </li>

        @endrole

        @role('escritor')
       
        <li class="nav-item">
            <a href="/categories" class="nav-link text-white d-flex align-items-center">
                <i class="bi bi-tags me-2"></i>
                <span>Categorías</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('suppliers.index') }}" class="nav-link text-white d-flex align-items-center">
                <i class="bi bi-truck me-2"></i>
                <span>Proveedores</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('productos.index') }}" class="nav-link text-white d-flex">
                <i class="bi bi-box-seam me-2"></i>
                <span>Productos</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="/inventory/stock" class="nav-link text-white d-flex align-items-center">
                <i class="bi bi-boxes me-2"></i>
                <span>Stock</span>
            </a>
        </li>

        <!-- Gestión de existencias con submenú -->
        <li class="nav-item">
            <a class="nav-link text-white d-flex align-items-center" data-bs-toggle="collapse" href="#stockSubmenu" role="button" aria-expanded="false" aria-controls="stockSubmenu">
                <i class="bi bi-cart-check me-2"></i>
                <span>Gestión de existencias</span>
                <i class="bi bi-chevron-down ms-auto"></i> <!-- Indicador de colapso -->
            </a>
            <ul class="collapse list-unstyled ps-3" id="stockSubmenu">
                <li class="nav-item">
                    <a href="{{ route('entradas.index') }}" class="nav-link text-white d-flex align-items-center">
                        <i class="bi bi-box-arrow-in-right me-2"></i>
                        <span>Entradas</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/inventory/stock/exits" class="nav-link text-white d-flex align-items-center">
                        <i class="bi bi-box-arrow-right me-2"></i>
                        <span>Salidas</span>
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-item">
            <a href="/inventory/reports" class="nav-link text-white d-flex align-items-center">
                <i class="bi bi-graph-up me-2"></i>
                <span>Reportes</span>
            </a>
        </li>

        @endrole
        <br>
        <br>
        <br>
        <br>

        @role('admin')
        <li class="nav-item">
            <a href="/inventory/reports" class="nav-link text-white d-flex align-items-center">
              
                <span>ADMIN</span>
            </a>
        </li>
        @endrole

        @role('escritor')
        <li class="nav-item">
            <a href="/inventory/reports" class="nav-link text-white d-flex align-items-center">
              
                <span>EDITOR</span>
            </a>
        </li>
        @endrole


    </ul>
</nav>

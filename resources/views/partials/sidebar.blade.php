<!-- resources/views/partials/sidebar.blade.php -->
<aside id="sidebar" class="col-md-6 col-sm-12 bg-dark p-0 vh-100">
    <div class="d-flex">
        <button class="toggle-btn" type="button">
            <i class="lni lni-grid-alt"></i>
        </button>
        <div class="sidebar-logo">
            <a href="#">Hojas Eco Villas</a>
        </div>
    </div>
    <ul class="sidebar-nav">
        <li class="sidebar-item">
            <a href="/home" class="sidebar-link">
                <i class="lni lni-agenda"></i>
                <span>Inicio</span>
            </a>
        </li>
        @role('admin')
            <li class="sidebar-item">
                <a href="/admin/users" class="sidebar-link">
                    <i class="bi bi-person me-2"></i>
                    <span>Gestión de usuarios</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a href="/categories" class="sidebar-link">
                    <i class="bi bi-tags me-2"></i>
                    <span>Categorías</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="{{ route('suppliers.index') }}" class="sidebar-link">
                    <i class="bi bi-truck me-2"></i>
                    <span>Proveedores</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="{{ route('productos.index') }}" class="sidebar-link">
                    <i class="bi bi-box-seam me-2"></i>
                    <span>Productos</span>
                </a>
            </li>
            <li class="sidebar-item">
        <a href="/productos/stock"  class="sidebar-link"> <!-- Aquí corriges -->
        <i class="bi bi-boxes me-2"></i>
        <span>Stock</span>

         </a>
         </li>
         <li class="sidebar-item">
        <a href="{{ route('productos.test') }}" class="sidebar-link">
        <i class="bi bi-boxes me-2"></i>
        <span>Vista de Prueba</span>
        </a>
       </li>

            <!-- Gestión de existencias con submenú -->
            <li class="sidebar-item">
                <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse"
                    data-bs-target="#auth" aria-expanded="false" aria-controls="auth">
                    <i class="bi bi-cart-check me-2"></i>
                    <span>Gestion de existencias</span>
                </a>
                <ul id="auth" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                    <li class="sidebar-item" class="bi bi-box-arrow-in-right me-2">
                        <a href="{{ route('entradas.index') }}" class="sidebar-link">Entradas</a>
                    </li>
                    <li class="sidebar-item" class="bi bi-box-arrow-right me-2">
                        <a href="{{ route('salidas.index') }}" class="sidebar-link">Salidas</a>
                    </li>
                </ul>
            </li>


            <li class="sidebar-item">
                <a href="/inventory/reports" Class="sidebar-link">
                    <i class="bi bi-graph-up me-2"></i>
                    <span>Reportess</span>
                </a>
            </li>
        @endrole

        @role('escritor')
            <li class="sidebar-item">
                <a href="/categories" class="sidebar-link">
                    <i class="bi bi-tags me-2"></i>
                    <span>Categorías</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="{{ route('suppliers.index') }}" class="sidebar-link">
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
            <li class="sidebar-item">
                <a href="/inventory/stock" class="sidebar-link">
                    <i class="bi bi-boxes me-2"></i>
                    <span>Stock</span>
                </a>
            </li>

            <!-- Gestión de existencias con submenú -->
            <li class="sidebar-item">
                <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse"
                    data-bs-target="#auth" aria-expanded="false" aria-controls="auth">
                    <i class="lni lni-protection"></i>
                    <span>Gestion de existencias</span>
                </a>
                <ul id="auth" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                    <li class="sidebar-item" class="bi bi-box-arrow-in-right me-2">
                        <a href="{{ route('entradas.index') }}" class="sidebar-link">Entradas</a>
                    </li>
                    <li class="sidebar-item" class="bi bi-box-arrow-right me-2">
                        <a href="/inventory/stock/exits" class="sidebar-link">Salidas</a>
                    </li>
                </ul>
            </li>

            <li class="sidebar-item">
                <a href="/inventory/reports" Class="sidebar-link">
                    <i class="bi bi-graph-up me-2"></i>
                    <span>Reportessss</span>
                </a>
            </li>
        @endrole
        <br>
        <br>
        <br>
        <br>

        @role('admin')
        <div class="sidebar-footer">
            <a href="#" class="sidebar-link">
                <i class="bi bi-person me-2"></i>
                <span>ADMIN</span>
            </a>
        </div>
        @endrole

        @role('escritor')
            <div class="sidebar-footer">
                <a href="#" class="sidebar-link">
                    <i class="bi bi-person me-2"></i>
                    <span>EDITOR</span>
                </a>
            </div>
        @endrole


    </ul>
</aside>
<script>
    // Código JavaScript para expandir y contraer el menú
    document.addEventListener("DOMContentLoaded", function() {
        const hamBurger = document.querySelector(".toggle-btn");

        // Verifica si el botón existe antes de añadir el evento
        if (hamBurger) {
            hamBurger.addEventListener("click", toggleSidebar);
        }

        function toggleSidebar() {
            // Cambia la clase del sidebar para expandir o contraer
            const sidebar = document.querySelector("#sidebar");
            if (sidebar) {
                sidebar.classList.toggle("expand");
            }
        }
    });
</script>

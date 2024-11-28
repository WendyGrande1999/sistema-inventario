<footer class="footer bg-light text-center text-lg-start">
    <div class="container py-3"> <!-- Ajuste de padding -->
        <!-- Botones de navegación rápida -->
        <div class="row">
            <div class="col-lg-6 col-md-12 mb-3 text-start">
                <h5 class="text-uppercase">Recursos</h5>
                <ul class="list-unstyled mb-2">
                    <li>
                    <a href="{{ route('ayuda') }}" class="text-dark">Ayuda</a>
                    </li>
                    <li>
                    <a href="{{ route('terminos') }}" class="text-dark">Términos y Condiciones</a>
                    </li>
                    <li>
                      <a href="{{ route('privacidad') }}" class="text-dark">Política de Privacidad</a>
                    </li>
                </ul>
            </div>
            <div class="col-lg-6 col-md-12 mb-3 text-end">
                <h5 class="text-uppercase">Hojas Eco Villa</h5>
                <ul class="list-unstyled">
                    <li>
                        <i class="bi bi-envelope me-2"></i> 
                        <a href="mailto:soporte@uls.edu.sv" class="text-dark">hojasecovillas@gmail.com</a>
                    </li>
                    <li>
                        <i class="bi bi-telephone me-2"></i> 
                        <a href="tel:+50312345678" class="text-dark">Tel: (+503) 6994-3358</a>
                    </li>
                </ul>
            </div>
        </div>

        <hr class="my-2" /> <!-- Espaciado reducido -->

        <!-- Copyright -->
        <div class="d-flex justify-content-between align-items-center">
            <div class="copyright text-start">
                &copy; Copyright <strong><span><a href="https://www.uls.edu.sv">Universidad Luterana Salvadoreña</a></span></strong>. Todos los derechos reservados
            </div>
            <div class="credits text-end">
                <a href="#" class="text-dark">Práctica Profesional Informática</a>
            </div>
        </div>
    </div>
</footer>

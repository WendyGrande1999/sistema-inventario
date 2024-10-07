<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Mi Aplicación')</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Estilos personalizados -->
    <link rel="stylesheet" href="{{ asset('assets/estilos.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/estilos_menu.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/estilos_dasboard.css') }}">

    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />

</head>
<body>
    <!-- Incluir la navbar -->

    <div class="container-fluid p-0 ">
        <div class="row">
            <div class="wrapper">
                <!-- Menú lateral -->

                @include('partials.sidebar')

                <!-- Contenido principal -->
                <div class="col-md-9 col-lg-10 p-0">
                    <!-- Encabezado -->


                    <header class="bg-bg-dark p-0">
                        @include('partials.nav')
                    </header>


                    <main class="p-5 main" id="main">
                        @yield('content')
                    </main>


                </div>
            </div>
        </div>
    </div>

    <!-- Agregando javascrips -->



    <!-- Bootstrap JS y Popper.js -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>


    <script src="https://code.jquery.com/jquery-migrate-3.3.2.min.js"></script>

    <!-- DataTables JavaScript -->
    <script src="https://cdn.datatables.net/1.13.0/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.0/js/dataTables.bootstrap5.min.js"></script>


    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.0/css/dataTables.bootstrap5.min.css">
    <script src="{{ asset('assets/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/js/main.js') }}"></script>

</body>

</html>

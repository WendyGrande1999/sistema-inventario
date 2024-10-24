<!-- resources/views/home.blade.php -->
@extends('layouts.app')

@section('title', 'Inicio')

@section('content')

    <div class="pagetitle">
        <h1>Dashboard</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/home">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">

            <!-- Left side columns -->
            <div class="col-sm-12">
                <div class="row">

                    <!-- Card de productos-->
                    <div class="col-xxl-4 col-md-6">
                        <div class="card info-card sales-card">
                            <div class="filter">
                                <a class="icon" href="{{ route('productos.index') }}" data-bs-toggle="dropdown"><i
                                        class="bi bi-three-dots"></i></a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                    <li class="dropdown-header text-start">
                                        <h6>Filter</h6>
                                    </li>

                                    <li><a class="dropdown-item" href="{{ route('productos.index') }}">Productos</a></li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">Productos <span>| Productos disponibles</span></h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-cart"></i>
                                    </div>
                                    <div class="ps-3">
                                        @php
                                            $cantidaddeproductos = DB::table('productos')->count();
                                        @endphp
                                        <h6>{{ $cantidaddeproductos }}</h6>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div><!-- End Sales Card -->

                    <!-- Card de categorias-->
                    <div class="col-xxl-4 col-md-6">
                        <div class="card info-card revenue-card">

                            <div class="filter">
                                <a class="icon" href="#" data-bs-toggle="dropdown"><i
                                        class="bi bi-three-dots"></i></a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                    <li class="dropdown-header text-start">
                                        <h6>Filter</h6>
                                    </li>

                                    <li><a class="dropdown-item" href="/categories">Categorias</a></li>
                                </ul>
                            </div>

                            <div class="card-body" href="/categories">
                                <h5 class="card-title">Categorias <span>| Categorias existentes</span></h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-tags me-2"></i>
                                    </div>
                                    <div class="ps-3">
                                        @php
                                            $cantidaddecategories = DB::table('categories')->count();
                                        @endphp
                                        <h6>{{ $cantidaddecategories }}</h6>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div><!-- End Revenue Card -->

                    <!-- Card Proveedores-->
                    <div class="col-xxl-4 col-xl-12">

                        <div class="card info-card customers-card">

                            <div class="filter">
                                <a class="icon" href="#" data-bs-toggle="dropdown"><i
                                        class="bi bi-three-dots"></i></a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                    <li class="dropdown-header text-start">
                                        <h6>Filter</h6>
                                    </li>
                                    <li><a class="dropdown-item" href="{{ route('suppliers.index') }}">Proveedores</a></li>
                                </ul>
                            </div>

                            <div class="card-body">
                                <h5 class="card-title">Proveedores <span>| Proveedores existentes</span></h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-people"></i>
                                    </div>
                                    <div class="ps-3">
                                        @php
                                        $cantidaddeproveedores = DB::table('proveedors')->count();
                                    @endphp
                                    <h6>{{ $cantidaddeproveedores }}</h6>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div><!-- End Customers Card -->

                </div>
                <div class="row">

                    <!-- EXISTENCIAS CARD -->
                    <div class="col-xxl-4 col-md-6">
                        <div class="card info-card sales-card">

                            <div class="filter">
                                <a class="icon" href="#" data-bs-toggle="dropdown"><i
                                        class="bi bi-three-dots"></i></a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                    <li class="dropdown-header text-start">
                                        <h6>Filter</h6>
                                    </li>
                                    <li><a class="dropdown-item" href="{{ route('entradas.index') }}">Existencias</a></li>
                                </ul>
                            </div>

                            <div class="card-body">
                                <h5 class="card-title">Existencias <span>| Entradas</span></h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-cart-check me-2"></i>
                                    </div>
                                    <div class="ps-3">
                                        @php
                                            $cantidaddeentradas = DB::table('entradas')->count();
                                        @endphp
                                        <h6>{{ $cantidaddeentradas }}</h6>


                                    </div>
                                </div>
                            </div>

                        </div>
                    </div><!-- End Sales Card -->

                    <!-- Card ENTRADAS -->
                    <div class="col-xxl-4 col-md-6">
                        <div class="card info-card revenue-card">

                            <div class="filter">
                                <a class="icon" href="#" data-bs-toggle="dropdown"><i
                                        class="bi bi-three-dots"></i></a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                    <li class="dropdown-header text-start">
                                        <h6>Filter</h6>
                                    </li>

                                    <li><a class="dropdown-item" href="{{ route('salidas.index') }}">Salidas</a></li>
                                </ul>
                            </div>

                            <div class="card-body">
                                <h5 class="card-title">Existencias <span>| Salidas</span></h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-cart-check me-2"></i>
                                    </div>
                                    <div class="ps-3">
                                        @php
                                        $cantidaddesalida = DB::table('salidas')->count();
                                    @endphp
                                    <h6>{{ $cantidaddesalida }}</h6>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div><!-- End Revenue Card -->


                </div>
            </div><!-- End Left side columns -->


        </div>
    </section>
@endsection

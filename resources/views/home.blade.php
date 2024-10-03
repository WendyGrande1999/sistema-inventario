<!-- resources/views/home.blade.php -->
@extends('layouts.app')

@section('title', 'Inicio')

@section('content')
<div class="container my-4" col-md-6 col-sm-12>
    <!-- Tabla para organizar los elementos con imágenes -->
    <table class="table table-bordered-none table-responsive">

        <tbody>
            <tr>
              <div class="card-body" >
                <div class="row">
                  <div class="col-xl-3 col-md-6">
                      <div class="card bg-primary text-white mb-4">
                          <div class="card-body">Categorias</div>
                          <div class="card-footer d-flex align-items-center justify-content-between">
                              <a class="small text-white stretched-link" href="{{ route('categories.index') }}">Detalle de categorias</a>
                              <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                          </div>
                      </div>
                  </div>
                  <div class="col-xl-3 col-md-6">
                      <div class="card bg-warning text-white mb-4">
                          <div class="card-body">Proveedores</div>
                          <div class="card-footer d-flex align-items-center justify-content-between">
                              <a class="small text-white stretched-link" href="{{ route('suppliers.index') }}">Detalles de proveedores</a>
                              <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                          </div>
                      </div>
                  </div>
                  <div class="col-xl-3 col-md-6">
                      <div class="card bg-success text-white mb-4">
                          <div class="card-body">Productos</div >
                          <div class="card-footer d-flex align-items-center justify-content-between">
                              <a class="small text-white stretched-link" href="{{ route('productos.index') }}">Detalles de productos</a>
                              <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                          </div>
                      </div>
                  </div>
                  <div class="col-xl-3 col-md-6">
                      <div class="card bg-danger text-white mb-4">
                          <div class="card-body">Usuarios</div>
                          <div class="card-footer d-flex align-items-center justify-content-between">
                              <a class="small text-white stretched-link" href="#">Detalles de usuarios</a>
                              <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                          </div>
                      </div>
                  </div>
              </div>
            </tr>
            <tr>
              <div class="card-body">
                <div class="row">
                  <div class="col-xl-3 col-md-6">
                      <div class="card bg-primary text-white mb-4">
                          <div class="card-body">Inventario</div>
                          <div class="card-footer d-flex align-items-center justify-content-between">

                              <a class="small text-white stretched-link" href="{{ route('categories.index') }}">Detalle de inventario</a>
                              <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                          </div>
                      </div>
                  </div>
                  <div class="col-xl-3 col-md-6">
                      <div class="card bg-warning text-white mb-4">
                          <div class="card-body">Entradas</div>
                          <div class="card-footer d-flex align-items-center justify-content-between">
                              <a class="small text-white stretched-link" href="{{ route('suppliers.index') }}">Detalles de entradas</a>
                              <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                          </div>
                      </div>
                  </div>
                  <div class="col-xl-3 col-md-6">
                      <div class="card bg-success text-white mb-4">
                          <div class="card-body">Salidas</div>
                          <div class="card-footer d-flex align-items-center justify-content-between">
                              <a class="small text-white stretched-link" href="{{ route('productos.index') }}">Detalles de salidas</a>
                              <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                          </div>
                      </div>
                  </div>
              </div>
            </tr>

        </tbody>
    </table>
</div>
@endsection

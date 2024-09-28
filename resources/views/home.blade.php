<!-- resources/views/home.blade.php -->
@extends('layouts.app')

@section('title', 'Inicio')

@section('content')
<div class="container my-4">
    <!-- Tabla para organizar los elementos con imágenes -->
    <table class="table table-bordered-none table-responsive">
        
        <tbody>
            <tr>
                <td>
                <div class="card" style="width: 18rem;">
                   <img  src="{{ asset('assets/playa.png')}}" class="card-img-top" alt="150px">

                    <div class="card-body">
                      <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                     </div>
                      </div>

                </td>
                <td>
                <div class="card" style="width: 18rem;">
                <img  src="{{ asset('assets/playa.png')}}" class="card-img-top" alt="150px">

                  <div class="card-body">
                  <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                </div>


                
                <div class="card-body">
                  <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                </div>
               </div>

                </td>

                <td>
                <div class="card" style="width: 18rem;">
                <img  src="{{ asset('assets/playa.png')}}" class="card-img-top" alt="150px">

                  <div class="card-body">
                  <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                </div>
               </div>

                </td>
            </tr>
         
        </tbody>
    </table>

    <!-- Botón para cerrar sesión -->
    <form action="{{ route('logout') }}" method="POST" class="mt-4">
        @csrf
        <button type="submit" class="btn btn-danger">Cerrar Sesión</button>
    </form>
</div>
@endsection

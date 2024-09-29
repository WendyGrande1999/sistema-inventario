@extends('layouts.app')
Prueba de subir cambios a git
@section('content')
<div class="container">
    <h1>Agregar usuario</h1>
    <br>
                                <form action="{{ route('users.store') }}" method="POST">
                                    @csrf

                                    <!-- Mostrar mensajes de éxito -->
                                    @if (session('success'))
                                        <div class="alert alert-success">
                                            {{ session('success') }}
                                        </div>
                                    @endif

                                    <!-- Mostrar mensajes de error -->
                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    <div class="form-outline mb-4">
                                        <label class="form-label" for="name">Nombre</label>
                                        <input type="text" name="name" id="name" class="form-control" placeholder="Nombre" required />
                                    </div>

                                    <div class="form-outline mb-4">
                                        <label class="form-label" for="email">Correo</label>
                                        <input type="email" name="email" id="email" class="form-control" placeholder="Correo electrónico" required />
                                    </div>

                                    <div class="form-outline mb-4">
                                        <label class="form-label" for="password">Contraseña</label>
                                        <input type="password" name="password" id="password" class="form-control" required />
                                    </div>

                                    <div class="form-outline mb-4">
                                        <label class="form-label" for="password_confirmation">Confirmar Contraseña</label>
                                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required />
                                    </div>

                                    <div class="text-center pt-1 mb-5 pb-1">
                                        <button class="btn btn-primary btn-block fa-lg gradient-custom-2 mb-3" type="submit">Agregar Usuario</button>
                                    </div>
                                </form>

</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Roles de {{ $user->name }}</h1>
    <form action="{{ route('admin.users.roles.assign', $user) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="roles">Roles</label>
            <select name="roles[]" id="roles" class="form-control" multiple>
                @foreach($roles as $role)
                <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                    {{ $role->name }}
                </option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-success">Asignar Roles</button>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Volver</a>
    </form>
</div>
@endsection

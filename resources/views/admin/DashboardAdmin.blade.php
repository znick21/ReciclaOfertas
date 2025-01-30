@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Bienvenido al Dashboard de Administrador</h2>
    <p>Este es el panel de administración. Desde aquí puedes gestionar el sistema.</p>

    <h3>Usuarios registrados</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <!-- Botón de editar -->
                        <a href="{{ route('admin.edit', $user->id) }}" class="btn btn-primary">Editar</a>

                        <!-- Formulario para eliminar usuario -->
                        <form action="{{ route('admin.delete', $user->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

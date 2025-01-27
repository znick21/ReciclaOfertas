@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow bg-light">
                <div class="card-header bg-success text-white">
                    <h1 class="mb-0">Detalle de la Oferta de Reciclaje: {{ $oferta->id }}</h1>
                </div>
                <div class="card-body">
                    @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover">
                                    <tbody>
                                        <tr>
                                            <th>ID</th>
                                            <td>{{ $oferta->id }}</td>
                                        </tr>
                                        <tr>
                                            <th>Usuario</th>
                                            <td>{{ $oferta->usuario->name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Dirección</th>
                                            <td>{{ $direccion }}</td> <!-- Mostrar la dirección calculada -->
                                        </tr>
                                        <tr>
                                            <th>Latitud</th>
                                            <td>{{ $oferta->latitud }}</td>
                                        </tr>
                                        <tr>
                                            <th>Longitud</th>
                                            <td>{{ $oferta->longitud }}</td>
                                        </tr>
                                        <tr>
                                            <th>Material</th>
                                            <td>{{ $oferta->material }}</td>
                                        </tr>
                                        <tr>
                                            <th>Cantidad</th>
                                            <td>{{ $oferta->cantidad }}</td>
                                        </tr>
                                        <tr>
                                            <th>Precio</th>
                                            <td>{{ number_format($oferta->precio, 2) }} €</td>
                                        </tr>
                                        <tr>
                                            <th>Estado</th>
                                            <td>{{ ucfirst($oferta->estado) }}</td>
                                        </tr>

                                        <!-- Mostrar el recolector que aceptó la oferta -->
                                        @if($recolector)
                                            <tr>
                                                <th>Recolector</th>
                                                <td>{{ $recolector->name }} ({{ $recolector->email }})</td>
                                            </tr>
                                        @else
                                            <tr>
                                                <th>Recolector</th>
                                                <td>No asignado</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="col-md-6 d-flex justify-content-center align-items-center">
                            @if($oferta->image && Storage::disk('public')->exists($oferta->image))
                            <img src="{{ asset('storage/' . $oferta->image) }}" class="img-fluid rounded max-height-300" alt="Imagen de la oferta">
                            @else
                            <div class="bg-success p-4 rounded text-white">
                                <i class="fas fa-recycle fa-3x"></i>
                                <p class="mt-2 mb-0">Sin imagen</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center mt-4">
        <div class="col-md-8">
            <div class="d-flex justify-content-between">
                <a href="{{ route('oferta.index') }}" class="btn btn-outline-success btn-sm">Volver a la lista de ofertas</a>
                
                <!-- Botón para ver la oferta en Google Maps -->
                <a href="https://www.google.com/maps/dir/?api=1&destination={{ $oferta->latitud }},{{ $oferta->longitud }}&travelmode=driving" class="btn btn-primary btn-sm" target="_blank">
                    Ver en Google Maps
                </a>

                <!-- Botón para completar la oferta (solo si el estado es 'aceptada' y el usuario es recolector) -->
                @if($oferta->estado === 'aceptada' && Auth::user()->role === 'recolector')
                    <form action="{{ route('oferta.completar', $oferta->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('¿Está seguro de que desea completar esta oferta?')">Completar Oferta</button>
                    </form>
                @endif
            </div>
        </div>
    </div>

</div>
@endsection

@extends('layouts.app')

@section('content')

<style>
/* Estilos generales */
.text-primary {
  color: #007bff !important;
}

.form-control-primary {
  background-color: #f8f9fa;
  border-color: #007bff;
  color: #007bff;
}

.form-control-primary::placeholder {
  color: #999;
}

.btn-primary {
  background-color: #007bff;
  border-color: #007bff;
  color: #fff;
  font-weight: bold;
}

.btn-primary:hover {
  background-color: #0056b3;
  border-color: #0056b3;
}

.btn-info {
  background-color: #17a2b8;
  border-color: #17a2b8;
}

.btn-warning {
  background-color: #ffc107;
  border-color: #ffc107;
}

.btn-danger {
  background-color: #dc3545;
  border-color: #dc3545;
}

.btn-success {
  background-color: #28a745;
  border-color: #28a745;
}

.card-yugioh {
  background-color: #f8f9fa;
  border: 2px solid #007bff;
  border-radius: 10px;
  box-shadow: 0 0 20px rgba(0, 123, 255, 0.5);
  position: relative;
  overflow: hidden;
  transition: transform 0.3s;
}

.card-yugioh:hover {
  transform: scale(1.05);
}

.card-yugioh .card-body {
  padding: 1rem;
  text-align: center;
}

.card-yugioh .card-title {
  font-size: 1.5rem;
  font-weight: bold;
  color: #fff;
  background-color: #007bff; /* Fondo azul para el título */
  padding: 10px;
  border-radius: 10px 10px 0 0; /* Bordes redondeados solo en la parte superior */
  margin: 0; /* Eliminar margen para que se extienda completamente */
}

.card-yugioh .card-text {
  font-size: 1rem;
  color: #333;
}

.badge-disponible {
  background-color: #007bff; /* Azul */
  color: #fff;
}

.badge-aceptada {
  background-color: #28a745; /* Verde */
  color: #fff;
}

.badge-rechazada {
  background-color: #dc3545; /* Rojo */
  color: #fff;
}

.badge-completada {
  background-color: #6c757d; /* Gris */
  color: #fff;
}

.img-primary {
  border: 2px solid #007bff;
  box-shadow: 0 0 10px rgba(0, 123, 255, 0.5);
  max-height: 150px;
  object-fit: cover;
}

/* Estilos específicos para el formulario de filtrado */
.form-group label.form-label.text-primary {
  font-weight: bold;
}

.form-group .form-control-primary {
  border-radius: 5px;
}

.form-group .btn-primary {
  border-radius: 5px;
  padding: 0.5rem 1.5rem;
}
</style>

<div class="container" style="max-width: 1000px; margin: auto; overflow-y: auto; height: 80vh; padding: 20px;">
   <h1 class="text-center mb-4 text-primary">Ofertas Disponibles</h1>

   <!-- Formulario de filtrado -->
   <form method="GET" action="{{ route('oferta.index') }}" class="mb-4">
      <div class="d-flex flex-wrap justify-content-center gap-3">
         <!-- Filtro por Estado -->
         <div class="form-group">
            <label for="estado" class="form-label text-primary">Estado</label>
            <select name="estado" id="estado" class="form-control form-control-primary">
               <option value="">Selecciona un estado</option>
               <option value="disponible" {{ request('estado') == 'disponible' ? 'selected' : '' }}>Disponible</option>
               <option value="aceptada" {{ request('estado') == 'aceptada' ? 'selected' : '' }}>Aceptada</option>
               <option value="rechazada" {{ request('estado') == 'rechazada' ? 'selected' : '' }}>Rechazada</option>
               <option value="completada" {{ request('estado') == 'completada' ? 'selected' : '' }}>Completada</option>
            </select>
         </div>

         <!-- Filtro por Precio Mínimo -->
         <div class="form-group">
            <label for="precio_min" class="form-label text-primary">Precio Mínimo</label>
            <input type="number" name="precio_min" id="precio_min" class="form-control form-control-primary" value="{{ request('precio_min') }}" placeholder="Precio Mínimo">
         </div>

         <!-- Filtro por Precio Máximo -->
         <div class="form-group">
            <label for="precio_max" class="form-label text-primary">Precio Máximo</label>
            <input type="number" name="precio_max" id="precio_max" class="form-control form-control-primary" value="{{ request('precio_max') }}" placeholder="Precio Máximo">
         </div>

         <!-- Filtro por Material -->
         <div class="form-group">
            <label for="material" class="form-label text-primary">Material</label>
            <select name="material" id="material" class="form-control form-control-primary">
               <option value="">Selecciona un material</option>
               @foreach($materiales as $material)
               <option value="{{ $material->material }}" {{ request('material') == $material->material ? 'selected' : '' }}>
                  {{ ucfirst($material->material) }}
               </option>
               @endforeach
            </select>
         </div>

         <!-- Botón de Filtrado -->
         <div class="form-group">
            <button type="submit" class="btn btn-primary">Filtrar</button>
         </div>
      </div>
   </form>

   <div class="d-flex justify-content-center mb-4">
      <a href="{{ route('oferta.create') }}" class="btn btn-success btn-primary">Agregar Oferta</a>
   </div>

   @if(session('success'))
   <div class="alert alert-success text-center text-primary">{{ session('success') }}</div>
   @endif
   @if(session('error'))
   <div class="alert alert-danger text-center text-primary">{{ session('error') }}</div>
   @endif

   <div class="row justify-content-center" style="overflow-y: auto; max-height: 60vh; padding-right: 10px;">
      @foreach($ofertas as $oferta)
      <div class="col-12 col-md-6 col-lg-4 mb-3">
         <div class="card card-yugioh">
            <div class="card-body">
               <h5 class="card-title">{{ $oferta->material }}</h5>
               <p class="card-text"><strong>Usuario:</strong> {{ $oferta->usuario->name }}</p>
               <p class="card-text"><strong>Dirección:</strong> {{ $oferta->direccion }}</p>
               <p class="card-text"><strong>Cantidad:</strong> {{ $oferta->cantidad }}</p>
               <p class="card-text"><strong>Precio:</strong> Bs{{ number_format($oferta->precio, 2) }}</p>
               <p class="card-text"><strong>Estado:</strong> 
                  <span class="badge badge-pill badge-{{ $oferta->estado }}">
                     {{ ucfirst($oferta->estado) }}
                  </span>
               </p>
               @if($oferta->image && Storage::disk('public')->exists($oferta->image))
               <img src="{{ asset('storage/' . $oferta->image) }}" class="img-fluid mb-3 img-primary">
               @else
               <p class="text-primary">Sin imagen</p>
               @endif
               <div class="d-flex flex-wrap justify-content-center gap-2">
                  <a href="{{ route('oferta.show', $oferta->id) }}" class="btn btn-info btn-sm btn-primary">Ver</a>
                  @if(auth()->user()->id == $oferta->usuario_id && $oferta->estado !== 'completada')
                  <a href="{{ route('oferta.edit', $oferta->id) }}" class="btn btn-warning btn-sm btn-primary">Editar</a>
                  <form action="{{ route('oferta.destroy', $oferta->id) }}" method="POST" style="display:inline;">
                     @csrf
                     @method('DELETE')
                     <button type="submit" class="btn btn-danger btn-sm btn-primary" onclick="return confirm('¿Estás seguro de eliminar esta oferta?')">Eliminar</button>
                  </form>
                  @endif
                  @if(Auth::user()->role === 'recolector')
                  @if ($oferta->estado === 'disponible')
                  <form action="{{ route('oferta.aceptar', $oferta->id) }}" method="POST" style="display:inline;">
                     @csrf
                     <button type="submit" class="btn btn-success btn-sm btn-primary">Aceptar</button>
                  </form>
                  @elseif ($oferta->estado === 'aceptada')
                  <form action="{{ route('oferta.rechazar', $oferta->id) }}" method="POST" style="display:inline;">
                     @csrf
                     <button type="submit" class="btn btn-danger btn-sm btn-primary" onclick="return confirm('¿Estás seguro de rechazar esta oferta?')">Rechazar</button>
                  </form>
                  @endif
                  @endif
               </div>
            </div>
         </div>
      </div>
      @endforeach
   </div>

   <div class="d-flex justify-content-center">
      {{ $ofertas->links('vendor.pagination.bootstrap-4') }}
   </div>
</div>

@endsection

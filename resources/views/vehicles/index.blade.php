{{-- resources/views/vehicles/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Vehículos Registrados')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1><i class="fas fa-car me-2"></i>Vehículos Registrados</h1>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addVehicleModal">
                <i class="fas fa-plus me-2"></i>Agregar Vehículo
            </button>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Lista de Vehículos</h5>
                    <small class="text-muted">Total: {{ $vehicles->total() }} vehículos</small>
                </div>
            </div>
            <div class="card-body">
                @if($vehicles->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Placa</th>
                                    <th>Tipo</th>
                                    <th>Marca/Modelo</th>
                                    <th>Color</th>
                                    <th>Propietario</th>
                                    <th>Estado</th>
                                    <th>Registrado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($vehicles as $vehicle)
                                <tr>
                                    <td><strong>{{ $vehicle->plate }}</strong></td>
                                    <td>
                                        <span class="badge bg-secondary">
                                            {{ ucfirst($vehicle->tipo->nombre ?? 'Sin tipo') }}


                                        </span>
                                    </td>
                                    <td>{{ $vehicle->brand }} {{ $vehicle->model }}</td>
                                    <td>{{ $vehicle->color }}</td>
                                    <td>
                                        @if($vehicle->owner)
                                            {{ $vehicle->owner->name }}
                                        @else
                                            <span class="text-muted">Sin asignar</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($vehicle->isParked())
                                            <span class="badge bg-warning text-dark">Estacionado</span>
                                        @else
                                            <span class="badge bg-success">Libre</span>
                                        @endif
                                    </td>
                                    <td>{{ $vehicle->created_at->format('d/m/Y') }}</td>
                                    <td>
                                        <a href="{{ route('vehicles.show', $vehicle) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Paginación -->
                    <div class="d-flex justify-content-center">
                        {{ $vehicles->links() }}
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-car fa-3x text-muted mb-3"></i>
                        <p class="text-muted">No hay vehículos registrados</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Modal para agregar vehículo -->
<div class="modal fade" id="addVehicleModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Registrar Nuevo Vehículo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="addVehicleForm">
                <div class="modal-body">
                    @csrf
                    <div class="mb-3">
                        <label for="plate" class="form-label">Placa</label>
                        <input type="text" class="form-control plate-input" name="plate" required 
                            pattern="[A-Z]{3}[0-9]{2}[0-9A-Z]" maxlength="6">
                        <div class="form-text">Formato: ABC123 o ABC12D</div>
                    </div>

                   <div class="mb-3">

                        <select name="tipo_vehiculo_id" id="type" class="form-select" required>
                            <option value="">Seleccione tipo de vehículo</option>
                            @foreach ($tipos as $tipo)
                            <option value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="brand" class="form-label">Marca</label>
                                <input type="text" class="form-control" name="brand">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="model" class="form-label">Modelo</label>
                                <input type="text" class="form-control" name="model">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="color" class="form-label">Color</label>
                        <input type="text" class="form-control" name="color">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Registrar Vehículo</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    $('.plate-input').on('input', function() {
        this.value = this.value.toUpperCase();
    });

    $('#addVehicleForm').on('submit', function(e) {
        e.preventDefault();
        
        $.ajax({
            url: '{{ route("vehicles.store") }}',
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                $('#addVehicleModal').modal('hide');
                location.reload();
            },
            error: function(xhr) {
                const response = xhr.responseJSON;
                let message = 'Error al registrar vehículo';
                
                if (response && response.errors) {
                    message = Object.values(response.errors).flat().join(', ');
                }
                
                alert(message);
            }
        });
    });
});
</script>
@endsection
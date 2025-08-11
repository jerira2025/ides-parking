{{-- resources/views/parking/dashboard.blade.php --}}
@extends('layouts.app')

@section('title', 'Dashboard - Parqueadero')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h1 class="mb-4">
            <i class="fas fa-tachometer-alt me-2"></i>Dashboard del Parqueadero
        </h1>
    </div>
</div>

<!-- Estadísticas -->
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="card-title">Espacios Disponibles</h5>
                        <h2>{{ $availableSpaces }}</h2>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-parking fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-danger text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="card-title">Espacios Ocupados</h5>
                        <h2>{{ $totalSpaces - $availableSpaces }}</h2>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-car fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-info text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="card-title">Total Espacios</h5>
                        <h2>{{ $totalSpaces }}</h2>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-list fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Formularios de Entrada y Salida -->
<div class="row mb-4">
    <div class="col-md-6">
        <div class="card parking-card">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="fas fa-sign-in-alt me-2"></i>Registrar Entrada</h5>
            </div>
            <div class="card-body">
                <form id="entryForm">
                    @csrf
                    <div class="mb-3">
                        <label for="entry_plate" class="form-label">Placa del Vehículo</label>
                        <input type="text" class="form-control plate-input" id="entry_plate" name="plate"
                            placeholder="ABC123" pattern="[A-Z]{3}[0-9]{2}[0-9A-Z]" maxlength="6" required>
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

                    <div class="mb-3">
                        <label for="entry_space" class="form-label">Espacio Disponible</label>
                        <select class="form-select" id="entry_space" name="espacio_id" required>
                            <option value="">Seleccione un tipo de vehículo primero</option>
                        </select>
                    </div>


                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="entry_brand" class="form-label">Marca</label>
                                <input type="text" class="form-control" id="entry_brand" name="brand">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="entry_model" class="form-label">Modelo</label>
                                <input type="text" class="form-control" id="entry_model" name="model">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="entry_color" class="form-label">Color</label>
                        <input type="text" class="form-control" id="entry_color" name="color">
                    </div>
                    <button type="submit" class="btn btn-success w-100">
                        <i class="fas fa-plus me-2"></i>Registrar Entrada
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card parking-card">
            <div class="card-header bg-danger text-white">
                <h5 class="mb-0"><i class="fas fa-sign-out-alt me-2"></i>Registrar Salida</h5>
            </div>
            <div class="card-body">
                <form id="exitForm">
                    @csrf
                    <div class="mb-3">
                        <label for="exit_plate" class="form-label">Placa del Vehículo</label>
                        <input type="text" class="form-control plate-input" id="exit_plate" name="plate"
                            placeholder="ABC123" pattern="[A-Z]{3}[0-9]{2}[0-9A-Z]" maxlength="6" required>
                        <div class="form-text">Formato: ABC123 o ABC12D</div>
                    </div>
                    <button type="submit" class="btn btn-danger w-100">
                        <i class="fas fa-sign-out-alt me-2"></i>Registrar Salida
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Vehículos Actualmente Estacionados -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-car me-2"></i>Vehículos Estacionados ({{ $activeEntries->count() }})</h5>
            </div>
            <div class="card-body">
                @if($activeEntries->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Placa</th>
                                <th>Tipo</th>
                                <th>Marca/Modelo</th>
                                <th>Color</th>
                                <th>Espacio</th>
                                <th>Hora de Entrada</th>
                                <th>Tiempo Estacionado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($activeEntries as $entry)
                            <tr>
                                <td><strong>{{ $entry->vehicle->plate }}</strong></td>
                                <td>
                                    <span class="badge bg-secondary">{{ $entry->vehicle->tipoVehiculo->nombre ?? 'Desconocido' }}</span>
                                </td>
                                


                                <td>{{ $entry->vehicle->brand }} {{ $entry->vehicle->model }}</td>
                                <td>{{ $entry->vehicle->color }}</td>
                                <td>
                                    @if ($entry->espacio)
                                    <span class="badge bg-info">
                                        Zona {{ $entry->espacio->zona->nombre ?? 'Sin zona' }} -
                                        Espacio #{{ $entry->espacio->numero_espacio }}
                                    </span>
                                    @else
                                    <span class="badge bg-secondary">No asignado</span>
                                    @endif
                                </td>
                                <td>{{ $entry->entry_time->format('d/m/Y H:i') }}</td>
                                <td>
                                    <span class="badge bg-warning text-dark">
                                        {{ $entry->entry_time->diffForHumans(null, true) }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center py-4">
                    <i class="fas fa-car fa-3x text-muted mb-3"></i>
                    <p class="text-muted">No hay vehículos estacionados actualmente</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Convertir a mayúsculas automáticamente
        $('.plate-input').on('input', function() {
            this.value = this.value.toUpperCase();
        });

        $('#entryForm').on('submit', function(e) {
            e.preventDefault();

            const submitBtn = $(this).find('button[type="submit"]');
            const originalText = submitBtn.html();

            submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Procesando...');

            // Enviar solicitud AJAX
            $.ajax({
                url: '{{ route("parking.entry") }}', // Asegúrate de que esta ruta esté configurada correctamente en tu archivo de rutas
                method: 'POST',
                data: $(this).serialize(), // Serializa el formulario correctamente
                success: function(response) {
                    if (response.success) {
                        showAlert('success', response.message);
                        $('#entryForm')[0].reset();
                        setTimeout(() => location.reload(), 1500);
                    } else {
                        showAlert('danger', response.message);
                    }
                },
                error: function(xhr) {
                    const response = xhr.responseJSON;
                    let message = 'Error al registrar entrada';

                    if (response && response.message) {
                        message = response.message;
                    } else if (response && response.errors) {
                        message = Object.values(response.errors).flat().join(', ');
                    }

                    showAlert('danger', message);
                },
                complete: function() {
                    submitBtn.prop('disabled', false).html(originalText);
                }
            });
        });


        // Formulario de salida
        $('#exitForm').on('submit', function(e) {
            e.preventDefault();

            const submitBtn = $(this).find('button[type="submit"]');
            const originalText = submitBtn.html();

            submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Procesando...');

            $.ajax({
                url: '{{ route("parking.exit") }}',
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    if (response.success) {
                        showAlert('success', response.message);
                        $('#exitForm')[0].reset();

                        // Mostrar información adicional
                        if (response.data && response.data.duration_minutes) {
                            const hours = Math.floor(response.data.duration_minutes / 60);
                            const minutes = response.data.duration_minutes % 60;
                            const duration = hours > 0 ? `${hours}h ${minutes}m` : `${minutes}m`;

                            showAlert('info', `Tiempo estacionado: ${duration}`);
                        }

                        setTimeout(() => location.reload(), 2000);
                    } else {
                        showAlert('danger', response.message);
                    }
                },
                error: function(xhr) {
                    const response = xhr.responseJSON;
                    let message = 'Error al registrar salida';

                    if (response && response.message) {
                        message = response.message;
                    } else if (response && response.errors) {
                        message = Object.values(response.errors).flat().join(', ');
                    }

                    showAlert('danger', message);
                },
                complete: function() {
                    submitBtn.prop('disabled', false).html(originalText);
                }
            });
        });

        function showAlert(type, message) {
            const alertHtml = `
            <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;

            $('.container').prepend(alertHtml);

            // Auto-dismiss after 5 seconds
            setTimeout(() => {
                $('.alert').fadeOut();
            }, 5000);
        }
    });


    // Escucha el cambio del tipo de vehículo para cargar espacios compatibles
    $('#type').on('change', function() {
        const tipoVehiculoId = $(this).val();

        if (!tipoVehiculoId) {
            $('#entry_space').html('<option value="">Seleccione un tipo de vehículo primero</option>');
            return;
        }

        $.ajax({
            url: '/espacios-disponibles/' + tipoVehiculoId,
            method: 'GET',
            success: function(data) {
                if (data.length === 0) {
                    $('#entry_space').html('<option value="">No hay espacios disponibles</option>');
                    return;
                }

                let options = '<option value="">Seleccione un espacio</option>';
                data.forEach(function(espacio) {
                    options += `<option value="${espacio.id}">Zona ${espacio.zona} - Espacio ${espacio.numero}</option>`;
                });

                $('#entry_space').html(options);
            },
            error: function() {
                $('#entry_space').html('<option value="">Error al cargar espacios</option>');
            }
        });
    });
</script>
@endsection
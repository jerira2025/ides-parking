@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Registrar Entrada</h1>
    <form action="{{ route('parking.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="license_plate" class="form-label">Placa del Vehículo</label>
            <input type="text" name="license_plate" id="license_plate" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="hourly_rate" class="form-label">Tarifa por Hora</label>
            <input type="number" name="hourly_rate" id="hourly_rate" class="form-control" value="5000" required>
        </div>
        <button type="submit" class="btn btn-primary">Registrar</button>
    </form>
</div>
@endsection
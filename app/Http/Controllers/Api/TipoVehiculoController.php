<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TipoVehiculo;

class TipoVehiculoController extends Controller
{
    public function index()
    {
        return TipoVehiculo::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'codigo' => 'required|string|max:3|unique:tipo_vehiculos,codigo',
            'nombre' => 'required|string|max:100',
        ]);

        $tipoVehiculo = TipoVehiculo::create($request->all());

        return response()->json([
            'success' => true,
            'data' => $tipoVehiculo
        ], 201);
    }

    public function show($id)
    {
        $tipoVehiculo = TipoVehiculo::find($id);

        if (!$tipoVehiculo) {
            return response()->json([
                'success' => false,
                'message' => 'Tipo de vehículo no encontrado'
            ], 404);
        }

        return response()->json($tipoVehiculo);
    }

    public function update(Request $request, $id)
    {
        $tipoVehiculo = TipoVehiculo::find($id);

        if (!$tipoVehiculo) {
            return response()->json([
                'success' => false,
                'message' => 'Tipo de vehículo no encontrado'
            ], 404);
        }

        $request->validate([
            'codigo' => 'sometimes|string|max:3|unique:tipo_vehiculos,codigo,' . $id,
            'nombre' => 'sometimes|string|max:100',
        ]);

        $tipoVehiculo->update($request->all());

        return response()->json([
            'success' => true,
            'data' => $tipoVehiculo
        ]);
    }

    public function destroy($id)
    {
        $tipoVehiculo = TipoVehiculo::find($id);

        if (!$tipoVehiculo) {
            return response()->json([
                'success' => false,
                'message' => 'Tipo de vehículo no encontrado'
            ], 404);
        }

        $tipoVehiculo->delete();

        return response()->json([
            'success' => true,
            'message' => 'Eliminado correctamente'
        ]);
    }
}

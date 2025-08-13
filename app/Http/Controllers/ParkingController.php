<?php

namespace App\Http\Controllers;

use App\Models\ParkingTicket;
use App\Http\Requests\StoreParkingTicketRequest;
use App\Http\Requests\UpdateParkingTicketRequest;
use Illuminate\Http\Request;
use Carbon\Carbon;
use PDF; // si usas barryvdh

class ParkingController extends Controller
{
    public function index()
    {
        $tickets = ParkingTicket::orderBy('entry_time', 'desc')->paginate(20);
        return view('parking.index', compact('tickets'));
    }

    public function create()
    {
        return view('parking.create');
    }

    public function store(StoreParkingTicketRequest $request)
    {
        $ticket = ParkingTicket::create([
            'license_plate' => strtoupper($request->license_plate),
            'hourly_rate' => $request->hourly_rate ?? 5000,
            'entry_time' => Carbon::now()
        ]);

        return redirect()->route('parking.index')->with('success', 'Entrada registrada. ID: '.$ticket->id);
    }

    public function show(ParkingTicket $parking)
    {
        return view('parking.show', ['ticket' => $parking]);
    }

    public function edit(ParkingTicket $parking)
    {
        return view('parking.edit', ['ticket' => $parking]);
    }

    public function update(UpdateParkingTicketRequest $request, ParkingTicket $parking)
    {
        $parking->update($request->only(['license_plate', 'hourly_rate']));
        return redirect()->route('parking.index')->with('success', 'Ticket actualizado.');
    }

    public function destroy(ParkingTicket $parking)
    {
        $parking->delete();
        return back()->with('success', 'Ticket eliminado.');
    }

    // Acción para registrar salida y calcular totales
    public function checkout(ParkingTicket $parking)
    {
        if ($parking->exit_time) {
            return back()->with('error', 'El ticket ya tiene salida registrada.');
        }

        $parking->exit_time = Carbon::now();
        $parking->calculateTotals();
        $parking->save();

        return redirect()->route('parking.show', $parking)->with('success', 'Salida registrada.');
    }

    // Generar PDF de factura
    public function invoice(ParkingTicket $parking)
    {
        $pdf = PDF::loadView('parking.invoice', ['ticket' => $parking]);
        return $pdf->stream('factura_'.$parking->id.'.pdf');
    }
}
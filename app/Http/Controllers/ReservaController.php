<?php

namespace App\Http\Controllers;

use App\Models\Horario;
use App\Models\Reserva;
use Illuminate\Http\Request;

class ReservaController extends Controller
{
    public function index()
    {

        $reservas = Reserva::with('user', 'horario', 'precio')->get();
        return view('reservas.index', compact('reservas'));
    }

    public function store(Request $request)
    {
        Reserva::create($request->all());
        $horario = Horario::find($request->horario_id);
        $horario->update(['estado' => 'No Disponible']);

        return redirect('/horarios')->with('success', 'Reserva pendiente de aprobación.');
    }

    public function aprobar($id)
    {
        // Encuentra la reserva específica
        $reserva = Reserva::find($id);

        // Si no se encuentra la reserva, retorna un error
        if (!$reserva) {
            return back()->with('error', 'Reserva no encontrada.');
        }

        // Cambia el estado de la reserva actual a 'Aprobada'
        $reserva->update(['estado' => 'Aprobada']);

        // Cambia el estado de las demás reservas con el mismo horario_id a 'Rechazada'
        Reserva::where('horario_id', $reserva->horario_id)
            ->where('id', '!=', $reserva->id) // Excluye la reserva aprobada actual
            ->update(['estado' => 'Rechazada']);

        return back()->with('success', 'Reserva aprobada. Las demás reservas para el mismo horario han sido rechazadas.');
    }

    public function rechazar($id)
    {
        $reserva = Reserva::find($id);
        $reserva->update(['estado' => 'Rechazada']);
        $reserva->horario->update(['estado' => 'Disponible']);
        return back()->with('success', 'Reserva rechazada.');
    }
}

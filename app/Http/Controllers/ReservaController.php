<?php

namespace App\Http\Controllers;

use App\Models\Horario;
use App\Models\Reserva;
use Illuminate\Http\Request;

class ReservaController extends Controller
{
    public function index()
    {
        $reservas = Reserva::with('user', 'horario')->get();
        return view('admin.reservas.index', compact('reservas'));
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
        $reserva = Reserva::find($id);
        $reserva->update(['estado' => 'Aprobada']);
        return back()->with('success', 'Reserva aprobada.');
    }

    public function rechazar($id)
    {
        $reserva = Reserva::find($id);
        $reserva->update(['estado' => 'Rechazada']);
        $reserva->horario->update(['estado' => 'Disponible']);
        return back()->with('success', 'Reserva rechazada.');
    }
}

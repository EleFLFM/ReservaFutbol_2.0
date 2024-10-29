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
        return view('reservas.index', compact('reservas'));
    }

    public function store(Request $request)
    {
        // Validar los datos recibidos (sin precio_id)
        $request->validate([
            'horario_id' => 'required|exists:horarios,id',
            'user_id' => 'required|exists:users,id',
        ]);

        // Verificar si el horario aún está disponible
        $horario = Horario::find($request->horario_id);
        
        if (!$horario) {
            return back()->with('error', 'El horario no fue encontrado.');
        }

        if ($horario->estado !== 'Disponible') {
            return back()->with('error', 'El horario ya no está disponible.');
        }

        // Crear la reserva con estado 'Pendiente'
        Reserva::create([
            'horario_id' => $request->horario_id,
            'user_id' => $request->user_id,
            'precio_id' => 1, // Valor por defecto
            'estado' => 'Pendiente',
        ]);

        // Cambiar el estado del horario a 'No Disponible'
        $horario->update(['estado' => 'No Disponible']);

        return redirect('/horarios')->with('success', 'Reserva creada exitosamente y pendiente de aprobación.');
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

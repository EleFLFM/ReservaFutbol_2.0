<?php

namespace App\Http\Controllers;

use App\Models\Horario;
use Illuminate\Http\Request;

class HorarioController extends Controller
{
    // Mostrar todos los horarios
    public function index()
    {
        $horarios = Horario::all(); 
        return view('horarios.index', compact('horarios'));
    }

    // Mostrar formulario para crear un horario
    public function create()
    {
        return view('horarios.create');
    }

    // Guardar el nuevo horario en la base de datos
    public function store(Request $request)
    {
        $request->validate([
            'hora' => 'required|string',
            'estado' => 'required|in:Disponible,No disponible',
        ]);

        Horario::create($request->all());

        return redirect()->route('horarios.index')->with('success', 'Horario creado exitosamente.');
    }

    // Mostrar un horario específico
    public function show(Horario $horario)
    {
        return view('horarios.show', compact('horario'));
    }

    // Mostrar formulario para editar un horario
    public function edit(Horario $horario)
    {
        return view('horarios.edit', compact('horario'));
    }

    // Actualizar el horario en la base de datos
    public function update(Request $request, Horario $horario)
    {
        $request->validate([
            'hora' => 'required|string',
            'estado' => 'required|in:Disponible,No disponible',
        ]);

        $horario->update($request->all());

        return redirect()->route('horarios.index')->with('success', 'Horario actualizado exitosamente.');
    }

    // Eliminar un horario de la base de datos
    public function destroy(Horario $horario)
    {
        $horario->delete();

        return redirect()->route('horarios.index')->with('success', 'Horario eliminado exitosamente.');
    }
}

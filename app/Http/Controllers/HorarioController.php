<?php

namespace App\Http\Controllers;

use App\Models\Horario;
use Illuminate\Http\Request;

class HorarioController extends Controller
{
    public function index()
    {
        $horarios = Horario::all(); // Asegúrate de que se obtienen los horarios
        return view('horarios.index', compact('horarios'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Horario;


use Illuminate\Http\Request;

class HorarioController extends Controller
{
    public function index()
    {
        $horarios = Horario::all();
        return view('horarios.index', compact('horarios'));
    }

    public function store(Request $request)
    {
        Horario::create($request->all());
        return redirect('/horarios');
    }
}

@extends('layouts.app')

@section('main')
<div class="horarios-container">
    @if($horarios->isEmpty())
        <p>No existen horarios disponibles</p>
    @else
        @foreach($horarios as $horario)
        <div>
            <p>{{ $horario->fecha }} - {{ $horario->hora }} - {{ $horario->estado }}</p>
            @if($horario->estado == 'Disponible')
                <form action="/reservas" method="POST">
                    @csrf
                    <input type="hidden" name="horario_id" value="{{ $horario->id }}">
                    <button type="submit">Reservar</button>
                </form>
            @endif
        </div>
        @endforeach
    @endif
</div>
@endsection
@extends('layouts.app')

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ReservaFutbol - Reserva tu cancha</title>
    <link rel="stylesheet" href="css/stylesWelcome.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">


</head>
@section('main')
<!DOCTYPE html>
<html>

<head>
    <style>
        .horarios-container {
            margin: 20px auto;
            max-width: 1000px;
            font-family: Arial, sans-serif;
        }

        .horarios-tabla {
            width: 100%;
            border-collapse: collapse;
            background: white;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .horarios-tabla th {
            background: #003366;
            color: white;
            padding: 15px;
            text-align: center;
            font-weight: 500;
        }

        .horarios-tabla td {
            padding: 12px;
            text-align: center;
            border: 1px solid #eee;
        }

        .horarios-tabla tr:nth-child(even) {
            background: #f9f9f9;
        }

        .estado {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 4px;
            font-size: 14px;
            margin-bottom: 8px;
        }

        .disponible {
            background: #e8f5e9;
            color: #2e7d32;
        }

        .ocupado {
            background: #ffebee;
            color: #c62828;
        }

        .btn-reservar {
            background: #4CAF50;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .btn-reservar:hover {
            background: #45a049;
        }

        .sin-horarios {
            text-align: center;
            padding: 20px;
            background: #f5f5f5;
            border-radius: 4px;
            color: #666;
        }
    </style>
</head>

<body>
    <div class="horarios-container">
        @if($horarios->isEmpty())
        <div class="sin-horarios">
            <p>No existen horarios disponibles</p>
        </div>
        @else
        <table class="horarios-tabla">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Estado</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                @foreach($horarios as $horario)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($horario->fecha)->format('d/m/Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($horario->hora)->format('H:i') }}</td>
                    <td>
                        <span class="estado {{ strtolower($horario->estado) }}">
                            {{ $horario->estado }}
                        </span>
                    </td>
                    <td>
                        @if($horario->estado == 'Disponible')
                        <form action="/reservas" method="POST">
                            @csrf
                            <input type="hidden" name="horario_id" value="{{ $horario->id }}">
                            <button type="submit" class="btn-reservar">Reservar</button>
                        </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div style="margin-top: 20;" class="pagination justify-content-center">
            {{ $horarios->links('pagination::bootstrap-4') }}
        </div>
        @endif
    </div>
</body>


</html>
@endsection
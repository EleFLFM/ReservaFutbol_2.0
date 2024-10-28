@extends('layouts.app')

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ReservaFutbol</title>
    <link rel="stylesheet" href="/css/stylesWelcome.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">


</head>
@section('main')
<!DOCTYPE html>
<html>

<body>
    <div class="horarios-container">
        @if($reservas->isEmpty())
        <div class="sin-horarios">
            <p>No existen reservas</p>
        </div>
        @else

        <table class="horarios-tabla">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Estado</th>
                    <th>Precio</th>
                    <th>Acción</th>

                </tr>
            </thead>
            <tbody>
                @foreach($reservas as $reserva)
                <tr>
                    <td>{{ $reserva->id }}</td>
                    <td>{{ $reserva->user_id }}</td>
                    <td>{{ $reserva->estado }}</td>
                    <td>{{ $reserva->precio_id }}</td>
                    <td> <button type="submit" class="btn btn-outline"></button>
                    </td>


                </tr>
                @endforeach
            </tbody>
        </table>


        @endif
    </div>
</body>


</html>
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
@endsection
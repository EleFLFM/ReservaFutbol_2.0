@extends('layouts.app')

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ReservaFutbol</title>
    <link rel="stylesheet" href="/css/stylesWelcome.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

@section('main')
<div class="container">
    <h2>Configuración de usuario</h2>
    <p>Mis datos personales:</p>
    <form action="{{ route('user.update')}}" method="POST">
        @csrf
        @method('PUT')
        <div class="card p-4 mb-4">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="nombre">Nombre completo</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('nombre', $user->name) }}" required>
                        <span class="input-group-text"><i class='bx bx-edit-alt'></i></span>
                    </div>
                </div>


                <div class="col-md-6 mb-3">
                    <label for="correo">Correo</label>
                    <div class="input-group">
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('correo', $user->email) }}" required>
                        <span class="input-group-text"><i class='bx bx-edit-alt'></i></span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="contrasena">Nueva Contraseña</label>
                    <input type="password" name="password" id="password" class="form-control">
                </div>

                <div class="form-group">
                    <label for="contrasena_confirmation">Confirmar Contraseña</label>
                    <input type="password" name="contrasena_confirmation" id="contrasena_confirmation" class="form-control">
                </div>
            </div>

            <div class="d-flex justify-content-end mt-3">
                <button type="button" class="btn btn-outline-secondary me-2">Cancelar cambios</button>
                <button type="submit" class="btn btn-primary">Guardar cambios</button>
            </div>
        </div>
    </form>
</div>

<style>
    .container {
        max-width: 600px;
        background-color: #f4f7fa;
        padding: 20px;
        border-radius: 10px;
        font-family: Arial, sans-serif;
    }

    .card {
        background-color: #ffffff;
        border-radius: 10px;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    }

    .input-group-text {
        background-color: #e7f3ff;
        border-radius: 50%;
    }

    label {
        font-weight: bold;
        color: #333;
    }

    .btn-outline-secondary {
        border-radius: 20px;
    }

    .btn-primary {
        background-color: #007bff;
        border-radius: 20px;
        color: white;
    }
</style>
@endsection
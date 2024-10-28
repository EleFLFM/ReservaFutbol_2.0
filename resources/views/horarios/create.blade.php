@extends('layouts.app')


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ReservaFutbol - Reserva tu cancha</title>
    <link rel="stylesheet" href="/css/stylesWelcome.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

@section('main')

<body>
    <div class="crear-horario-container">
        <h2 class="form-title">Crear Horarios</h2>

        <div class="alert alert-info">
            Puedes crear horarios entre las 7:00 AM y 10:00 PM
        </div>

        <form action="{{ route('horarios.store') }}" method="POST" id="horariosForm">
            @csrf

            <div class="form-group">
                <label class="form-label">Fecha</label>
                <input type="date"
                    name="fecha"
                    class="form-input"
                    min="{{ date('Y-m-d') }}"
                    required>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Hora Inicio</label>
                    <select name="hora_inicio" class="form-select" required>
                        @for($hora = 7; $hora <= 21; $hora++)
                            <option value="{{ sprintf('%02d:00', $hora) }}">
                            {{ sprintf('%02d:00', $hora) }}
                            </option>
                            @endfor
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Hora Fin</label>
                    <select name="hora_fin" class="form-select" required>
                        @for($hora = 8; $hora <= 22; $hora++)
                            <option value="{{ sprintf('%02d:00', $hora) }}">
                            {{ sprintf('%02d:00', $hora) }}
                            </option>
                            @endfor
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Estado</label>
                <select name="estado" class="form-select" required>
                    <option value="Disponible">Disponible</option>
                    <option value="Ocupado">Ocupado</option>
                </select>
            </div>

            <div id="previewSection" class="preview-section">
                <h3 class="preview-title">Vista previa de horarios a crear:</h3>
                <ul class="preview-list" id="previewList"></ul>
            </div>

            <button type="submit" class="btn-submit">Crear Horarios</button>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('horariosForm');
            const previewSection = document.getElementById('previewSection');
            const previewList = document.getElementById('previewList');

            function updatePreview() {
                const fecha = form.fecha.value;
                const horaInicio = parseInt(form.hora_inicio.value);
                const horaFin = parseInt(form.hora_fin.value);

                if (!fecha || !horaInicio || !horaFin) return;

                previewList.innerHTML = '';
                previewSection.style.display = 'block';

                for (let hora = horaInicio; hora < horaFin; hora++) {
                    const horaFormateada = `${String(hora).padStart(2, '0')}:00`;
                    const li = document.createElement('li');
                    li.className = 'preview-item';
                    li.textContent = `${fecha} - ${horaFormateada}`;
                    previewList.appendChild(li);
                }
            }

            form.fecha.addEventListener('change', updatePreview);
            form.hora_inicio.addEventListener('change', updatePreview);
            form.hora_fin.addEventListener('change', updatePreview);
        });
    </script>
    <style>
        .crear-horario-container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background: white;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            font-family: Arial, sans-serif;
        }

        .form-title {
            color: #003366;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #eee;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 500;
        }

        .form-input,
        .form-select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }

        .btn-submit {
            background: #4CAF50;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
        }

        .btn-submit:hover {
            background: #45a049;
        }

        .alert {
            padding: 12px;
            border-radius: 4px;
            margin-bottom: 20px;
        }

        .alert-info {
            background: #e3f2fd;
            color: #1565c0;
            border: 1px solid #bbdefb;
        }

        .preview-section {
            margin-top: 20px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 4px;
            display: none;
        }

        .preview-title {
            font-weight: 500;
            margin-bottom: 10px;
            color: #003366;
        }

        .preview-list {
            list-style: none;
            padding: 0;
            margin: 0;
            max-height: 200px;
            overflow-y: auto;
        }

        .preview-item {
            padding: 8px;
            border-bottom: 1px solid #eee;
            font-size: 14px;
        }
    </style>
</body>
@endsection


</html>
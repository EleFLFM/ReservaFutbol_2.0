@extends('layouts.app')


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ReservaFutbol - Reserva tu cancha</title>
    <link rel="stylesheet" href="/css/stylesWelcome.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
</head>
@section('main')
<div class="crear-horario-container">
    <h2 class="form-title">Crear Horarios</h2>

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

<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('horariosForm');
        const previewSection = document.getElementById('previewSection');
        const previewList = document.getElementById('previewList');
        const horaInicioSelect = form.hora_inicio;

        // Función para obtener la próxima hora disponible
        function getProximaHora() {
            const ahora = new Date();
            const hora = ahora.getHours();
            const minutos = ahora.getMinutes();
            return minutos > 0 ? hora + 1 : hora;
        }

        // Función para actualizar las horas disponibles
        function actualizarHorasDisponibles() {
            const proximaHora = getProximaHora();
            
            // Deshabilitar horas pasadas en el select de hora inicio
            Array.from(horaInicioSelect.options).forEach(option => {
                const optionHora = parseInt(option.value);
                option.disabled = optionHora < proximaHora || optionHora < 7;
                // Si la hora actual está deshabilitada y seleccionada, seleccionar la próxima hora disponible
                if (option.disabled && option.selected) {
                    const nextAvailable = Array.from(horaInicioSelect.options)
                        .find(opt => !opt.disabled);
                    if (nextAvailable) {
                        nextAvailable.selected = true;
                    }
                }
            });
        }

        // Actualizar horas disponibles al cargar y cada minuto
        actualizarHorasDisponibles();
        setInterval(actualizarHorasDisponibles, 60000);

        // Manejar el envío del formulario
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            const horaInicio = parseInt(form.hora_inicio.value);
            const proximaHora = getProximaHora();

            // Validar hora de inicio
            if (horaInicio < proximaHora) {
                Swal.fire({
                    title: 'Error',
                    text: `Solo puedes crear horarios a partir de las ${proximaHora}:00`,
                    icon: 'error',
                    confirmButtonText: 'Ok'
                });
                return;
            }

            Swal.fire({
                title: '¿Desea crear horarios de 7:00 a 22:00?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, crear horarios',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });

        function updatePreview() {
            const fecha = form.fecha.value;
            const horaInicio = parseInt(form.hora_inicio.value);
            const horaFin = parseInt(form.hora_fin.value);

            if (!fecha || !horaInicio || !horaFin) return;

            // Validar que hora fin sea mayor que hora inicio
            if (horaFin < horaInicio) {
                Swal.fire({
                    title: 'Error',
                    text: 'La hora de fin debe ser mayor que la hora de inicio',
                    icon: 'error',
                    confirmButtonText: 'Ok'
                });
                return;
            }

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
@endsection
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




</html>
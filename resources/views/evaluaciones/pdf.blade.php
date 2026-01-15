<!DOCTYPE html>
<html lang="es">
<meta charset="UTF-8">
    <title>Evaluación de Rendimiento</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #1f2937;
        }

        h1, h2, h3 {
            margin-bottom: 6px;
        }

        .header {
            border-bottom: 2px solid #16a34a;
            margin-bottom: 15px;
            padding-bottom: 10px;
        }

        .section {
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #e5e7eb;
            padding: 6px;
            text-align: left;
        }

        th {
            background: #f3f4f6;
        }

        .badge {
            padding: 4px 6px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: bold;
        }

        .badge-ok {
            background: #dcfce7;
            color: #166534;
        }

        table, tr, td, th {
            page-break-inside: avoid;
        }

        .chart-block {
            page-break-before: always;
        }
    </style>
</head>
<body>
    @php
    $usuario = $usuario ?? (object)['name' => 'N/A'];
    $resumen = $resumen ?? [];
    $detalle = $detalle ?? [];
    $charts = $charts ?? []; // Protección para $charts
@endphp

    {{-- ================= ENCABEZADO ================= --}}
    <div class="header">
        <h1>Evaluación de Rendimiento</h1>
        <p><strong>Cultivo:</strong> {{ $evaluacion->cultivo->nombre_comun ?? 'N/A' }}</p>
        <p><strong>Usuario:</strong> {{ $usuario->name ?? 'N/A' }}</p> <!-- Ahora $usuario está disponible -->
        <p><strong>Fecha:</strong> {{ optional($evaluacion->created_at)->format('d/m/Y') }}</p>
    </div>

    {{-- ================= RESUMEN ================= --}}
    <div class="section">
        <h2>Resumen General</h2>
        <table>
            <thead>
                <tr>
                    <th>Inversión Promedio</th>
                    <th>Ingresos Promedio</th>
                    <th>Cantidad Promedio</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>${{ number_format($resumen['inversion_promedio'] ?? 0, 2) }}</td>
                    <td>${{ number_format($resumen['ingresos_promedio'] ?? 0, 2) }}</td>
                    <td>{{ number_format($resumen['cantidad_promedio'] ?? 0, 2) }} kg</td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- ================= DETALLE ================= --}}
    <div class="section">
        <h2>Detalle por Siembra</h2>
        <table>
            <thead>
                <tr>
                    <th>Siembra</th>
                    <th>Inversión</th>
                    <th>Ingresos</th>
                    <th>Rentabilidad</th>
                    <th>Cantidad</th>
                </tr>
            </thead>
            <tbody>
                @forelse($detalle as $d)
                    <tr>
                        <td>{{ $d['label'] ?? 'Siembra' }}</td>
                        <td>${{ number_format($d['inversion'] ?? 0, 2) }}</td>
                        <td>${{ number_format($d['ingresos'] ?? 0, 2) }}</td>
                        <td>
                            <span class="badge badge-ok">
                                ${{ number_format($d['rentabilidad'] ?? 0, 2) }}
                            </span>
                        </td>
                        <td>{{ $d['cantidad'] ?? 0 }} kg</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align:center;color:#6b7280;">
                            No hay datos disponibles
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- ================= GRÁFICAS ================= --}}
    @if(!empty($charts))
        <div class="section">
            <h2>Gráficas</h2>
            @foreach($charts as $nombre => $dataUri)
                <div style="margin-bottom:20px;">
                    <h3>{{ ucfirst($nombre) }}</h3>
                    <img src="{{ $dataUri }}" style="width:100%; max-height:500px;">
                </div>
            @endforeach
        </div>
    @endif
</body>
</html>
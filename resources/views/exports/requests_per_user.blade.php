<table>
    <thead>
        <tr>
            <th>Usuario</th>
            <th>Total de Solicitudes</th>
            <th>Mes</th>
            <th>Año</th>
            <th>Semana</th>
        </tr>
    </thead>
    <tbody>
        @foreach($solicitudes as $solicitud)
            <tr>
                <td>{{ $solicitud->usuario }}</td>
                <td>{{ $solicitud->total_solicitudes }}</td>
                <td>{{ $mes ?? '—' }}</td>
                <td>{{ $anio ?? '—' }}</td>
                <td>{{ $semana ?? '—' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

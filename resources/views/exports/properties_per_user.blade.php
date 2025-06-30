<table>
    <thead>
        <tr>
            <th>Usuario</th>
            <th>Total de Solicitudes de Propiedades</th>
            <th>Mes</th>
            <th>Año</th>
            <th>Semana</th>
        </tr>
    </thead>
    <tbody>
        @foreach($solicitudes as $solicitud)
            <tr>
                <td>{{ $solicitud->usuario }}</td>
                <td>{{ $solicitud->total_solicitudes_de_propiedades }}</td>
                <td>{{ $mes ?? '—' }}</td>
                <td>{{ $anio ?? '—' }}</td>
                <td>{{ $semana ?? '—' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

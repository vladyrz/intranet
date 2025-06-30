<table>
    <thead>
        <tr>
            <th>Usuario</th>
            <th>Total de Ofertas</th>
            <th>Mes</th>
            <th>Año</th>
            <th>Semana</th>
        </tr>
    </thead>
    <tbody>
        @foreach($ofertas as $oferta)
            <tr>
                <td>{{ $oferta->usuario }}</td>
                <td>{{ $oferta->total_ofertas }}</td>
                <td>{{ $mes ?? '—' }}</td>
                <td>{{ $anio ?? '—' }}</td>
                <td>{{ $semana ?? '—' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

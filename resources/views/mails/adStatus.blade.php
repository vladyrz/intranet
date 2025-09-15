@if ($status === 'pending')
    <p>Se ha registrado una nueva solicitud de pauta del asesor: <strong>{{ $data['name'] }}</strong></p>
    <p>Datos de la solicitud:</p>
    <ul>
        <li>Plataforma: <strong>{{ $data['platform'] }}</strong></li>
        <li>Fecha de inicio: <strong>{{ $data['start_date'] }}</strong></li>
        <li>Fecha de finalización: <strong>{{ $data['end_date'] }}</strong></li>
    </ul>
@elseif ($status === 'scheduled')
    <p>Se ha programado una pauta del asesor: <strong>{{ $data['name'] }}</strong></p>
@elseif ($status === 'stopped')
    <p>Se ha detenido una pauta del asesor: <strong>{{ $data['name'] }}</strong></p>
@elseif ($status === 'finished')
    <p>Se ha finalizado una pauta del asesor: <strong>{{ $data['name'] }}</strong></p>
@endif

<a href="{{ $data['url'] }}">Ver solicitud en el sitio</a>

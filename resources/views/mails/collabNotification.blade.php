<p>Se ha registrado una nueva solicitud de colaboraci&oacute;n del asesor: <strong>{{ $data['name'] }}</strong></p>
<p>Datos de la solicitud:</p>
<ul>
    <li>Cliente: <strong>{{ $data['customer'] }}</strong></li>
    <li>Presupuesto del cliente: <strong>{{ $data['client_budget'] }} ₡</strong></li>
</ul>

<a href="{{ $data['url'] }}">Ver solicitud en el sitio</a>

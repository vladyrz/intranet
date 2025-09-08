@if($status === 'pending')
    <p>Se ha registrado un nuevo reporte de cliente para la propiedad: <strong>{{ $data['property_name'] }}</strong></p>
    <p>Datos del reporte:</p>
    <ul>
        <li>Nombre del cliente: <strong>{{ $data['customer_name'] }}</strong></li>
        <li>C&eacute;dula: <strong>{{ $data['customer_national_id'] }}</strong></li>
        <li>Banco/Financiera: <strong>{{ $data['organization'] }}</strong></li>
        <li>Asesor: <strong>{{ $data['name'] }}</strong></li>
    </ul>
@elseif($status === 'received')
    <p>Se ha recibido el reporte de cliente de: <strong>{{ $data['customer_name'] }}</strong>, con relaci&oacute;n a la propiedad: <strong>{{ $data['property_name'] }}</strong>.</p>
@elseif($status === 'approved')
    <p>Se ha aprobado el reporte de cliente de: <strong>{{ $data['customer_name'] }}</strong>, con relaci&oacute;n a la propiedad: <strong>{{ $data['property_name'] }}</strong>.</p>
@elseif($status === 'rejected')
    <p>Se ha rechazado el reporte de cliente de: <strong>{{ $data['customer_name'] }}</strong>, con relaci&oacute;n a la propiedad: <strong>{{ $data['property_name'] }}</strong>.</p>
    <p>Para m&aacute;s informaci&oacute;n, por favor revise la secci&oacute;n de comentarios en el registro de EasyCore.</p>
    <p>En caso de duda o de no haber comentarios, por favor contacte con soporte.</p>
@endif

<a href="{{ $data['url'] }}">Ver solicitud en el sitio</a>

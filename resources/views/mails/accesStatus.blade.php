@if($status === 'pending')
    <p>Se ha registrado una nueva solicitud de permiso de acceso a la propiedad: <strong>{{ $data['property'] }}</strong></p>
    <p>Datos de la solicitud:</p>
    <ul>
        <li>Nombre del solicitante: <strong>{{ $data['name'] }}</strong></li>
        <li>Tipo de solicitud: <strong>{{ $data['type_of_request'] }}</strong></li>
        <li>Banco/Financiera: <strong>{{ $data['organization'] }}</strong></li>
    </ul>
@elseif($status === 'received')
    <p>Se ha recibido la solicitud de permiso de la propiedad: <strong>{{ $data['property'] }}</strong></p>
    <p>Le notificaremos cualquier cambio en la solicitud.</p>
@elseif($status === 'sent')
    <p>Se ha enviado la solicitud de permiso de la propiedad: <strong>{{ $data['property'] }}</strong></p>
    <p>Le notificaremos cualquier cambio en la solicitud.</p>
@elseif($status === 'approved')
    <p>Se ha aprobado la solicitud de permiso de la propiedad: <strong>{{ $data['property'] }}</strong></p>
@elseif($status === 'rejected')
    <p>Se ha rechazado la solicitud de permiso de la propiedad: <strong>{{ $data['property'] }}</strong></p>
    <p>Para m&aacute;s informaci&oacute;n, por favor revise la secci&oacute;n de comentarios en el registro de EasyCore.</p>
    <p>En caso de duda o de no haber comentarios, por favor contacte con soporte.</p>
@endif

<a href="{{ $data['url'] }}">Ver solicitud en el sitio</a>

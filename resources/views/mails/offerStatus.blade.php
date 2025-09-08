@if($status === 'pending')
    <p>Se ha registrada una nueva oferta para la propiedad: <strong>{{ $data['property'] }}</strong></p>
    <p>Datos de la solicitud:</p>
    <ul>
        <li>Nombre del cliente: <strong>{{ $data['customer_name'] }}</strong></li>
        <li>C&eacute;dula: <strong>{{ $data['customer_national_id'] }}</strong></li>
        <li>Monto de la oferta: <strong>{{ $data['offer_amount'] }}</strong></li>
        <li>Banco/Financiera: <strong>{{ $data['organization'] }}</strong></li>
    </ul>
@elseif($status === 'received')
    <p>Se ha recibido la oferta de la propiedad: <strong>{{ $data['property'] }}</strong></p>
    <p>Le notificaremos cualquier novedad sobre la oferta.</p>
@elseif($status === 'sent')
    <p>Se ha enviado la oferta de la propiedad: <strong>{{ $data['property'] }}</strong></p>
    <p>Le notificaremos cualquier novedad sobre la oferta.</p>
@elseif($status === 'approved')
    <p>Se ha aprobado la oferta de la propiedad: <strong>{{ $data['property'] }}</strong></p>
@elseif($status === 'rejected')
    <p>Se ha rechazado la oferta de la propiedad: <strong>{{ $data['property'] }}</strong></p>
    <p>Para m&aacute;s informaci&oacute;n, por favor revise la secci&oacute;n de comentarios en el registro de EasyCore.</p>
    <p>En caso de duda o de no haber comentarios, por favor contacte con soporte.</p>
@elseif($status === 'signed')
    <p>Se ha firmado la oferta de la propiedad: <strong>{{ $data['property'] }}</strong></p>
@endif

<a href="{{ $data['url'] }}">Ver solicitud en el sitio</a>

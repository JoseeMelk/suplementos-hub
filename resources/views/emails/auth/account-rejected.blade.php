@component('mail::message')
# Hola, {{ $userName }}

Luego de revisar tu solicitud, lamentamos informarte que tu cuenta
no ha podido ser aprobada en este momento.

@if($reason)
**Motivo:** {{ $reason }}
@endif

Si crees que esto es un error o tienes dudas, responde este correo
y con gusto lo revisamos.

Gracias por tu interés,
**El equipo de Suplementos Hub**
@endcomponent
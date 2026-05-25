@component('mail::message')
# ¡Bienvenido, {{ $userName }}! 🎉

Tu cuenta ha sido **aprobada**. Ya puedes acceder a tu panel y comenzar a publicar tus productos.

@component('mail::button', ['color' => 'success', 'url' => $dashboardUrl])
Ir a mi panel
@endcomponent

Gracias por unirte a Suplementos Hub,
**El equipo de Suplementos Hub**
@endcomponent
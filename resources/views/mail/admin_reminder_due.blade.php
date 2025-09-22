@component('mail::message')
# {{ __('Hola :name,', ['name' => $user->name]) }}

{{ __('Tienes un recordatorio para hoy.') }}

**{{ __('Tipo') }}:** {{ __('translate.admin_reminder.options_reminder_type.' . $reminder->reminder_type) }}
**{{ __('Frecuencia') }}:** {{ __('translate.admin_reminder.options_frequency.' . $reminder->frequency) }}
**{{ __('Detalle') }}:** {{ $reminder->task_details }}

@endcomponent

<?php

namespace App\Helpers;

use Filament\Facades\Filament;

class FilamentUrlHelper

{
    /**
     * Generate the URL to a filament resource based on the user and model.
     *
     * @param \App\Models\User $user
     * @param string $resourceClass Example App\Filament\Personal\Resources\CustomerResource::class
     * @param int|\Illuminate\Database\Eloquent\Model $record
     * @param string $action (view, edit, etc.)
     * @return string
     */

    public static function getResourceUrl($user, string $resourceClass, $record, string $action = 'edit'): string
    {
        // Here we define the panel based on the user's role.
        $panel = match (true) {
            $user->hasRole('panel_user')          => 'personal',
            $user->hasRole('soporte')             => 'soporte',
            $user->hasRole('ventas')              => 'sales',
            $user->hasRole('servicio_al_cliente') => 'services',
            $user->hasRole('rrhh')                => 'rrhh',
            $user->hasRole('contabilidad')        => 'contabilidad',
            $user->hasRole('gerente')             => 'ops',
            $user->hasRole('super_admin')         => 'admin',
            default                               => 'admin',
        };

        // Make sure to have the ID.
        $recordId = $record instanceof \Illuminate\Database\Eloquent\Model ? $record->getKey() : $record;

        return $resourceClass::getUrl($action, [
            'record' => $recordId,
        ], panel: $panel);
    }
}

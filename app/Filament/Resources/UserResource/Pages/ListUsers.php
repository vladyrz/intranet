<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Models\User;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Colors\Color;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            null => Tab::make('All')->badge($this->orderByStatus() ?? 0)->label('Total de Usuarios'),
    
            true => Tab::make()->query(fn ($query) => $query->where('state', true))
                        ->badge($this->orderByStatus(true) ?? 0)
                        ->badgeColor(Color::Green)
                        ->label('Activos'),
    
            false => Tab::make()->query(fn ($query) => $query->where('state', false))
                        ->badge($this->orderByStatus(false) ?? 0)
                        ->badgeColor(Color::Red)
                        ->label('Inactivos'),
        ];
    }

    private function orderByStatus($status = null)
    {
        if (is_null($status)) {
            return User::count();
        }
        
        return User::where('state', $status)->count();
    }

}

<?php

namespace App\Filament\Resources\EmployeeResource\Pages;

use App\Filament\Resources\EmployeeResource;
use App\Models\Employee;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Colors\Color;

class ListEmployees extends ListRecords
{
    protected static string $resource = EmployeeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            null => Tab::make('All')
                ->badge($this->orderByStatus() ?? 0)
                ->badgeColor(Color::Orange)
                ->label(__('resources.employee.tab_total_employees')),
            'Pendiente' => Tab::make()
                ->query(fn ($query) => $query->where('progress_status', 'Pendiente'))
                ->badge($this->orderByStatus('Pendiente') ?? 0)
                ->badgeColor(Color::Amber),
            'En Formación' => Tab::make()
                ->query(fn ($query) => $query->where('progress_status', 'En Formación'))
                ->badge($this->orderByStatus('En Formación') ?? 0)
                ->badgeColor(Color::Indigo),
            'Certificado' => Tab::make()
                ->query(fn ($query) => $query->where('progress_status', 'Certificado'))
                ->badge($this->orderByStatus('Certificado') ?? 0)
                ->badgeColor(Color::Green),
            'Retirado' => Tab::make()
                ->query(fn ($query) => $query->where('progress_status', 'Retirado'))
                ->badge($this->orderByStatus('Retirado') ?? 0)
                ->badgeColor(Color::Red),
        ];
    }

    private function orderByStatus(string $status =null){
        if(blank($status)){
            return Employee::count();
        }
        return Employee::where('progress_status', $status)->count();
    }
}

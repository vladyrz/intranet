<?php

namespace App\Filament\Ops\Resources\PropertyAssignmentResource\Pages;

use App\Filament\Ops\Resources\PropertyAssignmentResource;
use App\Models\PropertyAssignment;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Colors\Color;

class ListPropertyAssignments extends ListRecords
{
    protected static string $resource = PropertyAssignmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            null => Tab::make(__('resources.property_assignment.tab_total_property_assignments'))
                ->badge($this->orderByAssignmentStatus() ?? 0)
                ->badgeColor(Color::Amber),
            Tab::make(__('resources.property_assignment.tab_pending'))
                ->badge($this->orderByAssignmentStatus('pending') ?? 0)
                ->badgeColor(Color::Orange),
            Tab::make(__('resources.property_assignment.tab_received'))
                ->badge($this->orderByAssignmentStatus('received') ?? 0)
                ->badgeColor(Color::Gray),
            Tab::make(__('resources.property_assignment.tab_submitted'))
                ->badge($this->orderByAssignmentStatus('submitted') ?? 0)
                ->badgeColor(Color::Indigo),
            Tab::make(__('resources.property_assignment.tab_approved'))
                ->badge($this->orderByAssignmentStatus('approved') ?? 0)
                ->badgeColor(Color::Green),
            Tab::make(__('resources.property_assignment.tab_rejected'))
                ->badge($this->orderByAssignmentStatus('rejected') ?? 0)
                ->badgeColor(Color::Red),
            Tab::make(__('resources.property_assignment.tab_published'))
                ->badge($this->orderByAssignmentStatus('published') ?? 0)
                ->badgeColor(Color::Teal),
            Tab::make(__('resources.property_assignment.tab_assigned'))
                ->badge($this->orderByAssignmentStatus('assigned') ?? 0)
                ->badgeColor(Color::Purple),
            Tab::make(__('resources.property_assignment.tab_finished'))
                ->badge($this->orderByAssignmentStatus('finished') ?? 0)
                ->badgeColor(Color::Lime),
        ];
    }

    public function orderByAssignmentStatus(?string $status = null){
        if(blank($status)){
            return PropertyAssignment::count();
        }
        return PropertyAssignment::where('property_assignment_status', $status)->count();
    }
}

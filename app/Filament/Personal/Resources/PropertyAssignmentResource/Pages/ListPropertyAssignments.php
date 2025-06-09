<?php

namespace App\Filament\Personal\Resources\PropertyAssignmentResource\Pages;

use App\Filament\Personal\Resources\PropertyAssignmentResource;
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
        $user_id = auth()->user()->id;
        return [
            null => Tab::make(__('resources.property_assignment.tab_total_property_assignments'))
                ->badge($this->orderByAssignmentStatus(null, $user_id) ?? 0)
                ->badgeColor(Color::Amber),
            Tab::make(__('resources.property_assignment.tab_pending'))
                ->badge($this->orderByAssignmentStatus('pending', $user_id) ?? 0)
                ->badgeColor(Color::Orange),
            Tab::make(__('resources.property_assignment.tab_received'))
                ->badge($this->orderByAssignmentStatus('received', $user_id) ?? 0)
                ->badgeColor(Color::Gray),
            Tab::make(__('resources.property_assignment.tab_submitted'))
                ->badge($this->orderByAssignmentStatus('submitted', $user_id) ?? 0)
                ->badgeColor(Color::Indigo),
            Tab::make(__('resources.property_assignment.tab_approved'))
                ->badge($this->orderByAssignmentStatus('approved', $user_id) ?? 0)
                ->badgeColor(Color::Green),
            Tab::make(__('resources.property_assignment.tab_rejected'))
                ->badge($this->orderByAssignmentStatus('rejected', $user_id) ?? 0)
                ->badgeColor(Color::Red),
            Tab::make(__('resources.property_assignment.tab_published'))
                ->badge($this->orderByAssignmentStatus('published', $user_id) ?? 0)
                ->badgeColor(Color::Teal),
            Tab::make(__('resources.property_assignment.tab_assigned'))
                ->badge($this->orderByAssignmentStatus('assigned', $user_id) ?? 0)
                ->badgeColor(Color::Purple),
            Tab::make(__('resources.property_assignment.tab_finished'))
                ->badge($this->orderByAssignmentStatus('finished', $user_id) ?? 0)
                ->badgeColor(Color::Lime),
        ];
    }

    public function orderByAssignmentStatus(?string $status = null, $user_id = null){
        $query = PropertyAssignment::where('user_id', $user_id);
        if(blank($status)){
            return $query->count();
        }
        return $query->where('property_assignment_status', $status)->count();
    }
}

<?php

namespace App\Filament\Personal\Widgets;

use App\Models\PropertyAssignment;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class PersonalStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make(__('resources.property_assignment.stats_overview.0'), $this->getPendingAssignments(Auth::user()))
                ->description(__('resources.property_assignment.stats_overview_description.0'))
                ->color('warning'),
            Stat::make(__('resources.property_assignment.stats_overview.1'), $this->getSubmittedAssignments(Auth::user()))
                ->description(__('resources.property_assignment.stats_overview_description.1'))
                ->color('info'),
            Stat::make(__('resources.property_assignment.stats_overview.2'), $this->getApprovedAssignments(Auth::user()))
                ->description(__('resources.property_assignment.stats_overview_description.2'))
                ->color('success')
        ];
    }

    protected function getPendingAssignments(User $user){
        $totalPendingAssignments = PropertyAssignment::where('user_id', $user->id)
            ->where('property_assignment_status', 'pending')->get()->count();

        return $totalPendingAssignments;
    }

    protected function getSubmittedAssignments(User $user){
        $totalSubmittedAssignments = PropertyAssignment::where('user_id', $user->id)
            ->where('property_assignment_status', 'submitted')->get()->count();

        return $totalSubmittedAssignments;
    }

    protected function getApprovedAssignments(User $user){
        $totalApprovedAssignments = PropertyAssignment::where('user_id', $user->id)
            ->where('property_assignment_status', 'approved')->get()->count();

        return $totalApprovedAssignments;
    }
}

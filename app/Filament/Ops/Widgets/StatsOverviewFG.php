<?php

namespace App\Filament\Ops\Widgets;

use App\Models\PropertyAssignment;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewFG extends BaseWidget
{
    protected static ?string $pollingInterval = null;
    public static ?int $sort = 1;

    protected function getColumns(): int
    {
        return 3;
    }

    protected function getStats(): array
    {

        $propertyPendingQty = PropertyAssignment::where('property_assignment_status', 'pending')->count();
        $propertySubmittedQty = PropertyAssignment::where('property_assignment_status', 'submitted')->count();
        $propertyApprovedQty = PropertyAssignment::where('property_assignment_status', 'approved')->count();

        return [
            Stat::make(__('resources.property_assignment.stats_overview.0'), $propertyPendingQty)
                ->description(__('resources.property_assignment.stats_overview_description.0'))
                ->color('warning'),
            Stat::make(__('resources.property_assignment.stats_overview.1'), $propertySubmittedQty)
                ->description(__('resources.property_assignment.stats_overview_description.1'))
                ->color('info'),
            Stat::make(__('resources.property_assignment.stats_overview.2'), $propertyApprovedQty)
                ->description(__('resources.property_assignment.stats_overview_description.2'))
                ->color('success')
        ];
    }
}

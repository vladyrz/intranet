<?php

namespace App\Traits;

use App\Models\PropertyAssignment;

trait PropertyAssignmentTrait
{
    protected function getChartData(): array
    {
        return PropertyAssignment::selectRaw("
            DATE_FORMAT(created_at, '%Y-%m') as month,
                COUNT(CASE WHEN property_assignment_status = 'pending' THEN 1 END) as pending,
                COUNT(CASE WHEN property_assignment_status = 'submitted' THEN 1 END) as submitted,
                COUNT(CASE WHEN property_assignment_status = 'approved' THEN 1 END) as approved,
                COUNT(CASE WHEN property_assignment_status = 'rejected' THEN 1 END) as rejected,
                COUNT(CASE WHEN property_assignment_status = 'published' THEN 1 END) as published,
                COUNT(CASE WHEN property_assignment_status = 'assigned' THEN 1 END) as assigned,
                COUNT(CASE WHEN property_assignment_status = 'finished' THEN 1 END) as finished
        ")
        ->groupBy('month')
        ->orderBy('month')
        ->get()
        ->keyBy('month')
        ->toArray();
    }
}

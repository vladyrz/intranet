<?php

namespace App\Exports;

use App\Models\PropertyAssignment;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PropertiesPerUserExport implements FromView, ShouldAutoSize
{
    protected $month;
    protected $year;
    protected $week;

    public function __construct(?int $month = null, ?int $year = null, ?int $week = null)
    {
        $this->month = $month;
        $this->year = $year;
        $this->week = $week;
    }

    public function view(): View
    {
        $query = PropertyAssignment::query()
            ->join('users', 'property_assignments.user_id', '=', 'users.id')
            ->selectRaw('users.name as usuario, COUNT(property_assignments.id) as total_solicitudes_de_propiedades')
            ->groupBy('users.name');

        if ($this->month) {
            $query->whereMonth('property_assignments.created_at', $this->month);
        }

        if ($this->year) {
            $query->whereYear('property_assignments.created_at', $this->year);
        }

        if ($this->week) {
            $query->whereRaw('WEEK(property_assignments.created_at, 1) = ?', [$this->week]);
        }

        $solicitudes = $query->get();

        return view('exports.properties_per_user', [
            'solicitudes' => $solicitudes,
            'mes' => $this->month,
            'anio' => $this->year,
            'semana' => $this->week,
        ]);
    }
}

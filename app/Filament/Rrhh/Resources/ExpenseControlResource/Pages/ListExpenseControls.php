<?php

namespace App\Filament\Rrhh\Resources\ExpenseControlResource\Pages;

use App\Enums\ExpenseCostType;
use App\Filament\Rrhh\Resources\ExpenseControlResource;
use App\Models\ExpenseControl;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Colors\Color;

class ListExpenseControls extends ListRecords
{
    protected static string $resource = ExpenseControlResource::class;

    public function getTabs(): array
    {
        return [
            null => Tab::make('Todos')
                ->badge($this->orderByCostType() ?? 0)
                ->badgeColor(Color::Amber),
            Tab::make('Únicos')
                ->query(fn($query) => $query->where('cost_type', ExpenseCostType::OneTime->value))
                ->badge($this->orderByCostType(ExpenseCostType::OneTime->value) ?? 0)
                ->badgeColor(Color::Orange),
            Tab::make('Quincenales')
                ->query(fn($query) => $query->where('cost_type', ExpenseCostType::Biweekly->value))
                ->badge($this->orderByCostType(ExpenseCostType::Biweekly->value) ?? 0)
                ->badgeColor(Color::Red),
            Tab::make('Mensuales')
                ->query(fn($query) => $query->where('cost_type', ExpenseCostType::Monthly->value))
                ->badge($this->orderByCostType(ExpenseCostType::Monthly->value) ?? 0)
                ->badgeColor(Color::Indigo),
            Tab::make('Trimestrales')
                ->query(fn($query) => $query->where('cost_type', ExpenseCostType::Quarterly->value))
                ->badge($this->orderByCostType(ExpenseCostType::Quarterly->value) ?? 0)
                ->badgeColor(Color::Teal),
            Tab::make('Semestrales')
                ->query(fn($query) => $query->where('cost_type', ExpenseCostType::Semiannual->value))
                ->badge($this->orderByCostType(ExpenseCostType::Semiannual->value) ?? 0)
                ->badgeColor(Color::Blue),
            Tab::make('Anuales')
                ->query(fn($query) => $query->where('cost_type', ExpenseCostType::Annual->value))
                ->badge($this->orderByCostType(ExpenseCostType::Annual->value) ?? 0)
                ->badgeColor(Color::Green),
        ];
    }

    public function orderByCostType(?string $type = null)
    {
        if (blank($type)) {
            return ExpenseControl::count();
        }
        return ExpenseControl::where('cost_type', $type)->count();
    }
}

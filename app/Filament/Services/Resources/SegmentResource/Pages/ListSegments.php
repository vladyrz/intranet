<?php

namespace App\Filament\Services\Resources\SegmentResource\Pages;

use App\Filament\Services\Resources\SegmentResource;
use App\Models\Segment;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;

class ListSegments extends ListRecords
{
    protected static string $resource = SegmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array {
        return [
            null => Tab::make(__('resources.segment.tab_all'))
                ->badge($this->orderByExperience() ?? 0)
                ->badgeColor('warning'),
            Tab::make(__('resources.segment.tab_new'))
                ->query(fn ($query) => $query->where('experience', 'new'))
                ->badge($this->orderByExperience('new') ?? 0)
                ->badgeColor('gray')
                ->icon('heroicon-o-light-bulb'),
            Tab::make(__('resources.segment.tab_intermediate'))
                ->query(fn ($query) => $query->where('experience', 'intermediate'))
                ->badge($this->orderByExperience('intermediate') ?? 0)
                ->badgeColor('info')
                ->icon('heroicon-o-chart-bar'),
            Tab::make(__('resources.segment.tab_advanced'))
                ->query(fn ($query) => $query->where('experience', 'advanced'))
                ->badge($this->orderByExperience('advanced') ?? 0)
                ->badgeColor('success')
                ->icon('heroicon-o-briefcase'),
            Tab::make(__('resources.segment.tab_specialized'))
                ->query(fn ($query) => $query->where('experience', 'specialized'))
                ->badge($this->orderByExperience('specialized') ?? 0)
                ->badgeColor('warning')
                ->icon('heroicon-o-trophy'),
        ];
    }

    public function orderByExperience(?string $experience = null) {
        if(blank($experience)){
            return Segment::count();
        }
        return Segment::where('experience', $experience)->count();
    }
}

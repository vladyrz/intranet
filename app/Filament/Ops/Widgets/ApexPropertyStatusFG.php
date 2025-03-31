<?php

namespace App\Filament\Ops\Widgets;

use App\Traits\PropertyAssignmentTrait;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class ApexPropertyStatusFG extends ApexChartWidget
{

    use PropertyAssignmentTrait;

    public static ?int $sort = 2;

    /**
     * Chart Id
     *
     * @var string
     */
    protected static string $chartId = 'apexPropertyAssignmentStatus';

    /**
     * Widget Title
     *
     * @var string|null
     */
    protected static ?string $heading = 'Cantidad de asignaciones';

    protected int|string|array $columnSpan = 'full';

    /**
     * Chart options (series, labels, types, size, animations...)
     * https://apexcharts.com/docs/options
     *
     * @return array
     */
    protected function getOptions(): array
    {

        $chartData = $this->getChartData();

        return [
            'chart' => [
                'type' => 'bar',
                'height' => 450,
                'width' => '100%',
                'stacked' => true,
            ],
            'legend' => [
                'position' => 'top',
                'horizontalAlign' => 'center',
                'fontFamily' => 'inherit',
            ],
            'series' => [
                [
                    'name' => __('resources.property_assignment.tab_pending'),
                    'data' => array_column($chartData, 'pending'),
                    'color' => '#facc15',
                ],
                [
                    'name' => __('resources.property_assignment.tab_submitted'),
                    'data' => array_column($chartData, 'submitted'),
                    'color' => '#3b82f6',
                ],
                [
                    'name' => __('resources.property_assignment.tab_approved'),
                    'data' => array_column($chartData, 'approved'),
                    'color' => '#10b981',
                ],
                [
                    'name' => __('resources.property_assignment.tab_rejected'),
                    'data' => array_column($chartData, 'rejected'),
                    'color' => '#ef4444',
                ],
                [
                    'name' => __('resources.property_assignment.tab_published'),
                    'data' => array_column($chartData, 'published'),
                    'color' => '#8b5cf6',
                ],
                [
                    'name' => __('resources.property_assignment.tab_assigned'),
                    'data' => array_column($chartData, 'assigned'),
                    'color' => '#f97316',
                ],
                [
                    'name' => __('resources.property_assignment.tab_finished'),
                    'data' => array_column($chartData, 'finished'),
                    'color' => '#14b8a6',
                ],
            ],
            'xaxis' => [
                'categories' => array_keys($chartData),
                'labels' => [
                    'style' => [
                        'fontFamily' => 'inherit',
                    ],
                ],
            ],
            'yaxis' => [
                'labels' => [
                    'style' => [
                        'fontFamily' => 'inherit',
                    ],
                ],
            ],
            'colors' => ['#f59e0b'],
        ];
    }
}

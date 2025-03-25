<?php

namespace App\Filament\Soporte\Widgets;

use App\Traits\PropertyAssignmentTrait;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class ApexPropertyAssignmentStatus extends ApexChartWidget
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
                    'name' => __('translate.property_assignment.options_property_assignment_status.0'),
                    'data' => array_column($chartData, 'pending'),
                    'color' => '#facc15',
                ],

                [
                    'name' => __('translate.property_assignment.options_property_assignment_status.1'),
                    'data' => array_column($chartData, 'submitted'),
                    'color' => '#3b82f6',
                ],
                [
                    'name' => __('translate.property_assignment.options_property_assignment_status.2'),
                    'data' => array_column($chartData, 'approved'),
                    'color' => '#10b981',
                ],
                [
                    'name' => __('translate.property_assignment.options_property_assignment_status.3'),
                    'data' => array_column($chartData, 'rejected'),
                    'color' => '#ef4444',
                ],
                [
                    'name' => __('translate.property_assignment.options_property_assignment_status.4'),
                    'data' => array_column($chartData, 'published'),
                    'color' => '#8b5cf6',
                ],
                [
                    'name' => __('translate.property_assignment.options_property_assignment_status.5'),
                    'data' => array_column($chartData, 'assigned'),
                    'color' => '#f97316',
                ],
                [
                    'name' => __('translate.property_assignment.options_property_assignment_status.6'),
                    'data' => array_column($chartData, 'finished'),
                    'color' => '#14b8a6',
                ]
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

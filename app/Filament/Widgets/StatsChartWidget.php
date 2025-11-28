<?php

namespace App\Filament\Widgets;

use Filament\Widgets\LineChartWidget;
use App\Models\Product;
use App\Models\Pack;
use App\Models\Service;
use App\Models\User;
use Carbon\Carbon;


class StatsChartWidget extends LineChartWidget
{
    protected static ?string $heading = 'Statistiques des entités';

    protected function getData(): array
    {
        $labels = [];
        $months = [];

        // Générer les 6 derniers mois
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $labels[] = $month->format('M');
            $months[] = $month;
        }

        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Produits',
                    'data' => $this->countPerMonth(Product::class, $months),
                ],
                [
                    'label' => 'Packs',
                    'data' => $this->countPerMonth(Pack::class, $months),
                ],
                [
                    'label' => 'Services',
                    'data' => $this->countPerMonth(Service::class, $months),
                ],
                [
                    'label' => 'Users',
                    'data' => $this->countPerMonth(User::class, $months),
                ],
            ],
        ];
    }

    private function countPerMonth($modelClass)
    {
        $counts = [];
        $months = now()->subMonths(5)->monthsUntil(now());

        foreach ($months as $month) {
            $counts[] = $modelClass::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();
        }

        return $counts;
    }
}


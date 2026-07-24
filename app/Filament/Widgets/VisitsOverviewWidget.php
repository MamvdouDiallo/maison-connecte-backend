<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\SiteVisit;
use Carbon\Carbon;

class VisitsOverviewWidget extends BaseWidget
{
    protected static ?int $sort = 0;
    protected int | string | array $columnSpan = 'full';

    protected function getStats(): array
    {
        $today = Carbon::today();
        $startOfMonth = Carbon::now()->startOfMonth();
        $yesterday = Carbon::yesterday();

        $visitesAujourdhui = SiteVisit::whereDate('created_at', $today)->count();
        $visitesHier = SiteVisit::whereDate('created_at', $yesterday)->count();

        $visitesMois = SiteVisit::where('created_at', '>=', $startOfMonth)->count();

        $totalVisites = SiteVisit::count();

        return [
            Stat::make('Visiteurs aujourd\'hui', $visitesAujourdhui)
                ->description($this->trend($visitesAujourdhui, $visitesHier) . ' vs hier')
                ->descriptionIcon($visitesAujourdhui >= $visitesHier ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($visitesAujourdhui >= $visitesHier ? 'success' : 'danger')
                ->chart($this->sparkline()),

            Stat::make('Visiteurs ce mois-ci', $visitesMois)
                ->description('Visiteurs uniques (1 par jour et par personne)')
                ->descriptionIcon('heroicon-m-users')
                ->color('info'),

            Stat::make('Total visiteurs', $totalVisites)
                ->description('Depuis la mise en place du compteur')
                ->descriptionIcon('heroicon-m-globe-alt')
                ->color('primary'),
        ];
    }

    private function trend(int $current, int $previous): string
    {
        $diff = $current - $previous;
        $sign = $diff >= 0 ? '+' : '';
        return $sign . $diff;
    }

    private function sparkline(): array
    {
        return collect(range(6, 0))
            ->map(fn ($i) => SiteVisit::whereDate('created_at', Carbon::today()->subDays($i))->count())
            ->values()
            ->toArray();
    }
}
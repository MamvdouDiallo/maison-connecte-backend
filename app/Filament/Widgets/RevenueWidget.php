<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Commande;
use Carbon\Carbon;

class RevenueWidget extends BaseWidget
{
    protected static ?int $sort = 2;

    protected int | string | array $columnSpan = 'full';
    protected static ?string $pollingInterval = null;

    protected function getStats(): array
    {
        $thisMonth    = Carbon::now()->startOfMonth();
        $lastMonth    = Carbon::now()->subMonth()->startOfMonth();
        $lastMonthEnd = Carbon::now()->subMonth()->endOfMonth();

        $revenueMois       = Commande::where('created_at', '>=', $thisMonth)->sum('total');
        $revenueMoisPrec   = Commande::whereBetween('created_at', [$lastMonth, $lastMonthEnd])->sum('total');
        $revenueTotal      = Commande::sum('total');
        $commandesTotal    = Commande::count();
        $panierMoyen       = $commandesTotal > 0 ? round($revenueTotal / $commandesTotal) : 0;

        $revenueMoisFormate     = number_format($revenueMois, 0, ',', ' ') . ' F CFA';
        $revenueTotalFormate    = number_format($revenueTotal, 0, ',', ' ') . ' F CFA';
        $panierMoyenFormate     = number_format($panierMoyen, 0, ',', ' ') . ' F CFA';

        $diff = $revenueMois - $revenueMoisPrec;
        $sign = $diff >= 0 ? '+' : '';
        $trendLabel = $revenueMoisPrec > 0
            ? $sign . number_format($diff, 0, ',', ' ') . ' F vs mois dernier'
            : 'Premier mois de données';

        return [
            Stat::make('CA ce mois', $revenueMoisFormate)
                ->description($trendLabel)
                ->descriptionIcon($diff >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($diff >= 0 ? 'success' : 'danger')
                ->chart($this->revenueSparkline()),

            Stat::make('CA total cumulé', $revenueTotalFormate)
                ->description($commandesTotal . ' commandes au total')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('primary'),

            Stat::make('Panier moyen', $panierMoyenFormate)
                ->description('Valeur moyenne par commande')
                ->descriptionIcon('heroicon-m-shopping-bag')
                ->color('info'),
        ];
    }

    private function revenueSparkline(): array
    {
        return collect(range(6, 0))
            ->map(fn($i) => (int) Commande::whereYear('created_at', now()->subMonths($i)->year)
                ->whereMonth('created_at', now()->subMonths($i)->month)
                ->sum('total')
            )
            ->values()
            ->toArray();
    }
}

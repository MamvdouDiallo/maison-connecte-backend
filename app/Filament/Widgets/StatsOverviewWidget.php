<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Commande;
use App\Models\Devis;
use App\Models\Contact;
use App\Models\QuoteRequest;
use App\Models\Product;
use App\Models\User;
use App\Models\Project;
use App\Models\Client;
use App\Models\BlogPost;
use Carbon\Carbon;

class StatsOverviewWidget extends BaseWidget
{
    protected static ?int $sort = 1;
    protected int | string | array $columnSpan = 'full';

    protected function getStats(): array
    {
        $thisMonth = Carbon::now()->startOfMonth();
        $lastMonth = Carbon::now()->subMonth()->startOfMonth();
        $lastMonthEnd = Carbon::now()->subMonth()->endOfMonth();

        // ── Activité ──────────────────────────────────────────────────────────
        $commandesMois     = Commande::where('created_at', '>=', $thisMonth)->count();
        $commandesMoisDernier = Commande::whereBetween('created_at', [$lastMonth, $lastMonthEnd])->count();

        $devisMois         = Devis::where('created_at', '>=', $thisMonth)->count();
        $devisMoisDernier  = Devis::whereBetween('created_at', [$lastMonth, $lastMonthEnd])->count();

        $contactsMois      = Contact::where('created_at', '>=', $thisMonth)->count();
        $contactsMoisDernier = Contact::whereBetween('created_at', [$lastMonth, $lastMonthEnd])->count();

        $quoteReqMois      = QuoteRequest::where('created_at', '>=', $thisMonth)->count();
        $quoteReqMoisDernier = QuoteRequest::whereBetween('created_at', [$lastMonth, $lastMonthEnd])->count();

        return [
            // ── Activité du mois ─────────────────────────────────────────────
            Stat::make('Commandes ce mois', $commandesMois)
                ->description($this->trend($commandesMois, $commandesMoisDernier))
                ->descriptionIcon($this->trendIcon($commandesMois, $commandesMoisDernier))
                ->color($commandesMois >= $commandesMoisDernier ? 'success' : 'danger')
                ->chart($this->sparkline(Commande::class)),

            Stat::make('Devis ce mois', $devisMois)
                ->description($this->trend($devisMois, $devisMoisDernier))
                ->descriptionIcon($this->trendIcon($devisMois, $devisMoisDernier))
                ->color($devisMois >= $devisMoisDernier ? 'warning' : 'danger')
                ->chart($this->sparkline(Devis::class)),

            Stat::make('Contacts ce mois', $contactsMois)
                ->description($this->trend($contactsMois, $contactsMoisDernier))
                ->descriptionIcon($this->trendIcon($contactsMois, $contactsMoisDernier))
                ->color($contactsMois >= $contactsMoisDernier ? 'info' : 'danger')
                ->chart($this->sparkline(Contact::class)),

            Stat::make('Demandes de devis', $quoteReqMois)
                ->description($this->trend($quoteReqMois, $quoteReqMoisDernier))
                ->descriptionIcon($this->trendIcon($quoteReqMois, $quoteReqMoisDernier))
                ->color($quoteReqMois >= $quoteReqMoisDernier ? 'primary' : 'danger')
                ->chart($this->sparkline(QuoteRequest::class)),

            // ── Catalogue & Portfolio ─────────────────────────────────────────
            Stat::make('Projets réalisés', Project::count())
                ->description(Project::where('is_active', true)->count() . ' publiés')
                ->descriptionIcon('heroicon-m-briefcase')
                ->color('success'),

            Stat::make('Partenaires', Client::count())
                ->description(Client::where('is_active', true)->count() . ' actifs')
                ->descriptionIcon('heroicon-m-building-office-2')
                ->color('info'),

            Stat::make('Articles blog', BlogPost::count())
                ->description('Contenu publié')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('warning'),

            Stat::make('Produits catalogue', Product::count())
                ->description(User::count() . ' utilisateurs inscrits')
                ->descriptionIcon('heroicon-m-tag')
                ->color('gray'),
        ];
    }

    private function trend(int $current, int $previous): string
    {
        if ($previous === 0) {
            return $current > 0 ? '+' . $current . ' vs mois dernier' : 'Aucun le mois dernier';
        }
        $diff = $current - $previous;
        $sign = $diff >= 0 ? '+' : '';
        return $sign . $diff . ' vs mois dernier';
    }

    private function trendIcon(int $current, int $previous): string
    {
        return $current >= $previous
            ? 'heroicon-m-arrow-trending-up'
            : 'heroicon-m-arrow-trending-down';
    }

    private function sparkline(string $model): array
    {
        return collect(range(6, 0))
            ->map(fn($i) => $model::whereYear('created_at', now()->subMonths($i)->year)
                ->whereMonth('created_at', now()->subMonths($i)->month)
                ->count()
            )
            ->values()
            ->toArray();
    }
}

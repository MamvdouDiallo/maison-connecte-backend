<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget\Card;

use App\Models\Product;
use App\Models\Pack;
use App\Models\Service;
use App\Models\User;

class StatsOverviewWidget extends BaseWidget
{


     protected function getCards(): array
    {
        return [
            Card::make('Produits', Product::count()),
            Card::make('Packs', Pack::count()),
            Card::make('Services', Service::count()),
            Card::make('Users', User::count()),
        ];
    }
}

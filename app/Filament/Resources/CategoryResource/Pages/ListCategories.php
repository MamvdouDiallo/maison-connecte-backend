<?php

namespace App\Filament\Resources\CategoryResource\Pages;

use App\Filament\Resources\CategoryResource;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;

class ListCategories extends ListRecords
{
    protected static string $resource = CategoryResource::class;

    public function mount(): void
    {
        parent::mount();

        Notification::make()
            ->title('Catégories verrouillées')
            ->body('Ces 4 catégories sont liées au frontend Angular. Seules les traductions (FR/EN) et descriptions peuvent être modifiées. Toute création ou suppression casserait le site.')
            ->info()
            ->persistent()
            ->send();
    }

    protected function getHeaderActions(): array
    {
        return [];
    }
}

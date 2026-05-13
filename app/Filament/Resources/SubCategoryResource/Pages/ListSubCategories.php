<?php

namespace App\Filament\Resources\SubCategoryResource\Pages;

use App\Filament\Resources\SubCategoryResource;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;

class ListSubCategories extends ListRecords
{
    protected static string $resource = SubCategoryResource::class;

    public function mount(): void
    {
        parent::mount();

        Notification::make()
            ->title('Sous-catégories verrouillées')
            ->body('Ces 16 sous-catégories sont liées au frontend Angular. Seules les traductions (FR/EN) peuvent être modifiées. Toute création ou suppression casserait le filtrage des produits sur le site.')
            ->info()
            ->persistent()
            ->send();
    }

    protected function getHeaderActions(): array
    {
        return [];
    }
}

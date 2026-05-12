<?php

namespace App\Filament\Resources\FinitionResource\Pages;

use App\Filament\Resources\FinitionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFinitions extends ListRecords
{
    protected static string $resource = FinitionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

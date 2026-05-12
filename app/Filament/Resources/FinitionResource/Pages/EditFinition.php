<?php

namespace App\Filament\Resources\FinitionResource\Pages;

use App\Filament\Resources\FinitionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFinition extends EditRecord
{
    protected static string $resource = FinitionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
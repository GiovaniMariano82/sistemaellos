<?php

namespace App\Filament\Resources\TypeProviderResource\Pages;

use App\Filament\Resources\TypeProviderResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTypeProviders extends ListRecords
{
    protected static string $resource = TypeProviderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->icon('eos-note-add-o'),
        ];
    }
}

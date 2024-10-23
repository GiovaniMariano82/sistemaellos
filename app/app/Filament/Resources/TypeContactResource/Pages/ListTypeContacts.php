<?php

namespace App\Filament\Resources\TypeContactResource\Pages;

use App\Filament\Resources\TypeContactResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTypeContacts extends ListRecords
{
    protected static string $resource = TypeContactResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->icon('eos-note-add-o'),
        ];
    }
}

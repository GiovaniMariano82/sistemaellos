<?php

namespace App\Filament\Resources\TypeGenderResource\Pages;

use App\Filament\Resources\TypeGenderResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTypeGenders extends ListRecords
{
    protected static string $resource = TypeGenderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->icon('eos-note-add-o'),
        ];
    }
}

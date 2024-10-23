<?php

namespace App\Filament\Resources\TypeRoomResource\Pages;

use App\Filament\Resources\TypeRoomResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTypeRooms extends ListRecords
{
    protected static string $resource = TypeRoomResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->icon('eos-note-add-o'),
        ];
    }
}

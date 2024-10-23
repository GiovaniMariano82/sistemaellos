<?php

namespace App\Filament\Resources\TypeRoomResource\Pages;

use App\Filament\Resources\TypeRoomResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTypeRoom extends EditRecord
{
    protected static string $resource = TypeRoomResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->icon('heroicon-o-trash'),
        ];
    }

    protected function getSaveFormAction(): Actions\Action
    {
        return parent::getSaveFormAction()
            ->icon('eos-save');
    }

    protected function getCancelFormAction(): Actions\Action
    {
        return parent::getCancelFormAction()
            ->icon('eos-exit-to-app');
    }
}

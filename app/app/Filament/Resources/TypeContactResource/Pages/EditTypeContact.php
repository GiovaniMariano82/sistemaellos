<?php

namespace App\Filament\Resources\TypeContactResource\Pages;

use App\Filament\Resources\TypeContactResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTypeContact extends EditRecord
{
    protected static string $resource = TypeContactResource::class;

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

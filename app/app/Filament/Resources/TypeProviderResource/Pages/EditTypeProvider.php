<?php

namespace App\Filament\Resources\TypeProviderResource\Pages;

use App\Filament\Resources\TypeProviderResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTypeProvider extends EditRecord
{
    protected static string $resource = TypeProviderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
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

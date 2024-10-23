<?php

namespace App\Filament\Resources\TypeProviderResource\Pages;

use App\Filament\Resources\TypeProviderResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;

class CreateTypeProvider extends CreateRecord
{
    protected static string $resource = TypeProviderResource::class;

    protected function getCreateFormAction(): Action
    {
        return parent::getCreateFormAction()
            ->icon('eos-save');
    }

    protected function getCreateAnotherFormAction(): Action
    {
        return parent::getCreateAnotherFormAction()
            ->icon('eos-save');
    }

    protected function getCancelFormAction(): Action
    {
        return parent::getCancelFormAction()
            ->icon('eos-exit-to-app');
    }
}

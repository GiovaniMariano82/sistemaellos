<?php

namespace App\Filament\Resources\TypeContactResource\Pages;

use App\Filament\Resources\TypeContactResource;
use Filament\Actions;
use Filament\Actions\Action;

use Filament\Resources\Pages\CreateRecord;

class CreateTypeContact extends CreateRecord
{
    protected static string $resource = TypeContactResource::class;

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

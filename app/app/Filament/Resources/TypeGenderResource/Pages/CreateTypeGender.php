<?php

namespace App\Filament\Resources\TypeGenderResource\Pages;

use App\Filament\Resources\TypeGenderResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;

class CreateTypeGender extends CreateRecord
{
    protected static string $resource = TypeGenderResource::class;

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

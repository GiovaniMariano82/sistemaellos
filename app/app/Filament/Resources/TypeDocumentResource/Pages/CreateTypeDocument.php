<?php

namespace App\Filament\Resources\TypeDocumentResource\Pages;

use App\Filament\Resources\TypeDocumentResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;

class CreateTypeDocument extends CreateRecord
{
    protected static string $resource = TypeDocumentResource::class;

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

<?php

namespace App\Filament\Resources\RegisterCustomerResource\Pages;

use App\Filament\Resources\RegisterCustomerResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Carbon\Carbon;
use Filament\Actions\Action;
use Filament\Notifications\Notification;

class CreateRegisterCustomer extends CreateRecord
{
    protected static string $resource = RegisterCustomerResource::class;

    protected function mutateFormDataBeforeCreate($data): array
    {
        $data['start_date'] = Carbon::createFromFormat('d/m/Y', $data['start_date'])->format('Y-m-d');
        $data['end_date'] = Carbon::createFromFormat('d/m/Y', $data['end_date'])->format('Y-m-d');

        return $data;
    }

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

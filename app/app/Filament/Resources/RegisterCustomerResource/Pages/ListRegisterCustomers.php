<?php

namespace App\Filament\Resources\RegisterCustomerResource\Pages;

use App\Filament\Resources\RegisterCustomerResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRegisterCustomers extends ListRecords
{
    protected static string $resource = RegisterCustomerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->icon('eos-note-add-o'),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return RegisterCustomerResource::getWidgets();
    }
}

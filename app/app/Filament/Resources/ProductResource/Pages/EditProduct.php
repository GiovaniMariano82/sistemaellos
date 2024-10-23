<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProduct extends EditRecord
{
    protected static string $resource = ProductResource::class;

    // protected function mutateFormDataBeforeFill(array $data): array
    // {
    //     $data['price'] = number_format(($data['price'] / 100), 2, ',', '.');

    //     return $data;
    // }

    // protected function mutateFormDataBeforeSave(array $data): array
    // {
    //     $data['price'] = ((float) str_replace(['.',','],['','.'], $data['price'])) * 100;

    //     return $data;
    // }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->icon('heroicon-o-trash'),
            // Actions\CreateAction::make()
            //     ->icon('eos-note-add-o'),
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

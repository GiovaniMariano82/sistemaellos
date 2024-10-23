<?php

namespace App\Filament\Resources\RegisterCustomerResource\Pages;

use App\Filament\Resources\RegisterCustomerResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Carbon\Carbon;
use Filament\Actions\Action as ActionsAction;
use Filament\Actions\StaticAction;
use Filament\Forms\Components\Actions\Action;
use Filament\Notifications\Notification;

class EditRegisterCustomer extends EditRecord
{
    protected static string $resource = RegisterCustomerResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['start_date'] = Carbon::createFromFormat('d/m/Y', $data['start_date'])->format('Y-m-d');
        $data['end_date'] = Carbon::createFromFormat('d/m/Y', $data['end_date'])->format('Y-m-d');
        return $data;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('notify_user_financial')
                ->label('Gerar Financeiro')
                ->icon('eos-attach-money')
                ->requiresConfirmation()
                ->action(function($record){

                    //dd($record['id']);

                    Notification::make()
                    ->title('Saved successfully. Id: ' . $record['id'])
                    ->success()
                    ->send();
                }),

            Actions\DeleteAction::make()
                ->icon('heroicon-o-trash'),
        ];
    }

    protected function getSaveFormAction(): Actions\Action
    {
        return parent::getSaveFormAction()
            ->submit(null)
            ->icon('eos-save')
            ->requiresConfirmation()
            ->action(function(){
                $this->closeActionModal();
                $this->save();
            });
    }

    protected function getCancelFormAction(): Actions\Action
    {
        return parent::getCancelFormAction()
            ->icon('eos-exit-to-app');
    }
}

<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;


class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('change_password')
                ->label('Alterar senha')
                ->icon('heroicon-o-lock-closed')
                ->form([
                TextInput::make('password')
                    ->label('Senha')
                    ->password()
                    ->required()
                    ->revealable(),
                TextInput::make('password_confirmation')
                    ->label('Confirmar Senha')
                    ->password()
                    ->same('password')
                    ->revealable(),
                ])->action(function(array $data){
                    $this->record->update([
                        'password'=> bcrypt($data['password'])
                    ]);
                    //$this->notify('success', 'Senha atualizada com sucesso!');
                    Notification::make()
                        ->title('Alterado com sucesso')
                        ->body('Alteração da senha do usuário foi salva.')
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
            ->icon('eos-save');
    }

    protected function getCancelFormAction(): Actions\Action
    {
        return parent::getCancelFormAction()
            ->icon('eos-exit-to-app');
    }
}

<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Support\Colors\Color;
use Filament\Tables\Columns\IconColumn;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-c-user';
    protected static ?string $navigationGroup = 'Configurações de Acesso';
    protected static ?int $navigationSort = 91;
    protected static ?string $navigationLabel = 'Usuários';
    protected static ?string $modelLabel = 'usuário';
    protected static ?string $pluralModelLabel = 'usuários';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Dados de acesso')
                    ->description('Entre com os dados de acesso e dados pessoais do usuário.')
                    ->icon('eos-recent-actors-o')
                    ->columns(2)
                    ->collapsible()
                    ->schema([
                        TextInput::make('name')
                            ->label('Nome Completo')
                            ->required(),
                        TextInput::make('email')
                            ->label('E-mail do usuário')
                            ->email()
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->autocomplete(false),
                        Select::make('role')
                            ->label('Função')
                            ->relationship('roles', 'name')
                            ->multiple()
                            ->columnSpanFull(),
                        // CheckboxList::make('roles')
                        //     ->label('Função')
                        //     ->relationship('roles', 'name')
                        //     ->searchable(),
                        TextInput::make('password')
                            ->label('Senha')
                            ->password()
                            ->revealable()
                            ->visibleOn('create'),
                        TextInput::make('password_confirmation')
                            ->label('Confirmar Senha')
                            ->password()
                            ->same('password')
                            ->revealable()
                            ->visibleOn('create'),
                        ToggleButtons::make('active')
                            ->label('Usuário está ativo?')
                            ->boolean()
                            ->default(1)
                            ->grouped(),
                    ]),
                Section::make('Foto do usuário')
                    ->description('Selecione uma imagem para ser usada como avatar pelo usuário')
                    ->icon('eos-photo-camera-front-o')
                    ->collapsed()
                    ->schema([
                        FileUpload::make('photo')
                            ->disk('s3')
                            ->label('')
                            ->directory('users'),
                            //->image()
                            //->avatar()
                            //->imageEditor()
                            //->circleCropper(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('Código')
                    ->sortable(),
                TextColumn::make('name')
                    ->label('Nome Completo')
                    ->sortable()
                    ->searchable(),
                ImageColumn::make('photo')
                    ->disk('s3')
                    ->circular()
                    ->label('Foto'),
                TextColumn::make('email')
                    ->label('E-mail')
                    ->sortable()
                    ->searchable(),
                IconColumn::make('active')
                    ->label('Ativo ?')
                    ->boolean()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->hiddenLabel()
                    ->button(),
                Tables\Actions\EditAction::make()
                    ->hiddenLabel()
                    ->button(),
                Tables\Actions\DeleteAction::make()
                    ->hiddenLabel()
                    ->button(),
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\Action::make('change_password')
                        ->label('Alterar senha')
                        ->color(Color::Blue)
                        ->icon('heroicon-o-lock-closed')
                        ->form([
                            TextInput::make('password')
                                ->label('Senha')
                                ->password()
                                ->required()
                                ->revealable()
                                ->autocomplete(false),
                            TextInput::make('password_confirmation')
                                ->label('Confirmar Senha')
                                ->password()
                                ->same('password')
                                ->revealable()
                                ->autocomplete(false),
                        ])->action(function(User $user, array $data){
                            $user->update([
                                'password'=> bcrypt($data['password'])
                            ]);
                            Notification::make()
                                ->title('Alterado com sucesso')
                                ->body('Alteração da senha do usuário foi salva.')
                                ->success()
                                ->send();
                        }),
                ])->color(Color::Gray),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    // public static function getNavigationBadge(): string
    // {
    //     return static::getModel()::count();
    // }
}

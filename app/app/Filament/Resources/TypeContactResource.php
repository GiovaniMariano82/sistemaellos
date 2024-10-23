<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TypeContactResource\Pages;
use App\Filament\Resources\TypeContactResource\RelationManagers;
use App\Models\TypeContact;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TypeContactResource extends Resource
{
    protected static ?string $model = TypeContact::class;

    protected static ?string $navigationIcon = 'eos-contact-phone-o';
    protected static ?string $navigationGroup = 'Cadastros';
    protected static ?int $navigationSort = 44;
    protected static ?string $navigationLabel = 'Tipo Contatos';
    protected static ?string $modelLabel = 'tipo contato';
    protected static ?string $pluralModelLabel = 'tipo contatos';

    public static function form(Form $form): Form
    {
        return $form
            ->columns(2)
            ->schema([
                Section::make('Dados do estado:')
                    ->description('Entre com os dados de estados de registro.')
                    ->icon('eos-description-o')
                    ->collapsible()
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->label('Nome')
                            //->helperText('Nome completo do produto.')
                            ->autofocus()
                            ->required()
                            ->markAsRequired()
                            ->columnSpanFull(),
                        DateTimePicker::make('created_at')
                            ->label('Data de Criação')
                            ->disabled()
                            ->visibleOn(['edit', 'view']),
                            //->date('d/m/Y H:i:s'),
                        DateTimePicker::make('updated_at')
                            ->label('Data de Alteração')
                            ->disabled()
                            ->visibleOn(['edit', 'view']),
                            //->date('d/m/Y H:i:s'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('Código')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('name')
                    ->label('Nome')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('created_at')
                    ->date('d/m/Y H:i:s')
                    ->label('Data Criação')
                    ->sortable(),
                TextColumn::make('updated_at')
                    ->date('d/m/Y H:i:s')
                    ->label('Data Criação')
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
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListTypeContacts::route('/'),
            //'create' => Pages\CreateTypeContact::route('/create'),
            //'edit' => Pages\EditTypeContact::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): string
    {
        return static::getModel()::count();
    }
}

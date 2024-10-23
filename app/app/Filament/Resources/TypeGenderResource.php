<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TypeGenderResource\Pages;
use App\Filament\Resources\TypeGenderResource\RelationManagers;
use App\Models\TypeGender;
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

class TypeGenderResource extends Resource
{
    protected static ?string $model = TypeGender::class;

    protected static ?string $navigationIcon = 'healthicons-n-sexual-reproductive-health';
    protected static ?string $navigationGroup = 'Cadastros';
    protected static ?int $navigationSort = 46;
    protected static ?string $navigationLabel = 'Tipo Gênero';
    protected static ?string $modelLabel = 'tipo gênero';
    protected static ?string $pluralModelLabel = 'tipo gêneros';

    public static function form(Form $form): Form
    {
        return $form
            ->columns(2)
            ->schema([
                Section::make('Dados do estado:')
                    ->description('Entre com os dados do tipo de gênero.')
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
                            ->label('Data Criação')
                            ->disabled()
                            ->visibleOn(['edit', 'view']),
                            //->date('d/m/Y H:i:s'),
                        DateTimePicker::make('updated_at')
                            ->label('Data Alteração')
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
                    ->label('Data Alteração')
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
            'index' => Pages\ListTypeGenders::route('/'),
            //'create' => Pages\CreateTypeGender::route('/create'),
            //'edit' => Pages\EditTypeGender::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): string
    {
        return static::getModel()::count();
    }
}

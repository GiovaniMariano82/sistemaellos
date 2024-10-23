<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TypeProviderResource\Pages;
use App\Filament\Resources\TypeProviderResource\RelationManagers;
use App\Models\TypeProvider;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TypeProviderResource extends Resource
{
    protected static ?string $model = TypeProvider::class;

    protected static ?string $navigationIcon = 'healthicons-f-tac';
    protected static ?string $navigationGroup = 'Cadastros';
    protected static ?int $navigationSort = 43;
    protected static ?string $navigationLabel = 'Tipo Colaborador';
    protected static ?string $modelLabel = 'tipo colaborador';
    protected static ?string $pluralModelLabel = 'tipo colaboradores';

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
                        ToggleButtons::make('active')
                            ->label('Estado está ativo?')
                            ->boolean()
                            ->default(1)
                            ->grouped(),
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
                IconColumn::make('active')
                    ->label('Ativo ?')
                    ->boolean()
                    ->sortable(),
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
                // Tables\Actions\ViewAction::make()
                //     ->hiddenLabel()
                //     ->button(),
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
            'index' => Pages\ListTypeProviders::route('/'),
            //'create' => Pages\CreateTypeProvider::route('/create'),
            //'edit' => Pages\EditTypeProvider::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): string
    {
        return static::getModel()::count();
    }
}

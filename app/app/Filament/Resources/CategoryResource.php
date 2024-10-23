<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Filament\Resources\CategoryResource\RelationManagers;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'eos-sell-o';
    protected static ?string $navigationGroup = 'Cadastros';

    protected static ?int $navigationSort = 41;
    protected static ?string $navigationLabel = 'Categorias';
    protected static ?string $modelLabel = 'categoria';
    protected static ?string $pluralModelLabel = 'categorias';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Nome')
                    ->helperText('Nome da categoria de produtos.')
                    ->autofocus()
                    ->required()
                    ->markAsRequired()
                    ->maxLength(40)
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (string $operation, $state, Forms\Set $set) {
                        if ($operation !== 'create') {return;}
                        $set('slug',Str::slug($state));
                    }),
                TextInput::make('slug')
                    ->label('Slug')
                    ->disabled()
                    ->dehydrated()
                    ->required()
                    ->maxLength(60)
                    ->unique(Category::class, 'slug', ignoreRecord: true),
                TextInput::make('description')
                    ->label('Descrição')
                    ->helperText('Descrição da categoria de produtos.')
                    ->maxLength(255)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->sortable(),
                TextColumn::make('name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('created_at')
                    ->date('d/m/Y H:i:s')
                    ->label('Data Criação'),
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
            'index' => Pages\ListCategories::route('/'),
            //'create' => Pages\CreateCategory::route('/create'),
            //'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }

    /**
     * Função de exemplo para desabilitar a tela de criação
     * @return bool
     */
    // public static function canCreate(): bool
    // {
    //     return false;
    // }

    public static function getNavigationBadge(): string
    {
        return static::getModel()::count();
    }
}

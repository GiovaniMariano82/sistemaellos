<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Filament\Resources\ProductResource\Widgets\ProductsStatsOverview;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Set;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Filters\Filter;
use Illuminate\Support\Str;
use Leandrocfe\FilamentPtbrFormFields\Money;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'eos-products-o';
    protected static ?string $navigationGroup = 'Gestão de Vendas';
    protected static ?int $navigationSort = 31;
    protected static ?string $navigationLabel = 'Produtos';
    protected static ?string $modelLabel = 'produto';
    protected static ?string $pluralModelLabel = 'produtos';

    public static function form(Form $form): Form
    {
        return $form
            ->columns(2)
            ->schema([
                Section::make('Dados do produto:')
                    ->description('Entre com os dados de indentificação do produto.')
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
                            ->columnSpanFull()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (string $operation, $state, Forms\Set $set) {
                                if ($operation !== 'create') {return;}
                                $set('slug', Str::slug($state));
                            }),
                        TextInput::make('slug')
                            ->label('Slug do Produto')
                            ->disabled()
                            ->columnSpanFull()
                            ->dehydrated()
                            ->required()
                            ->maxLength(255)
                            ->unique(Product::class, 'slug', ignoreRecord: true),
                        Textarea::make('description')
                            ->label('Descrição')
                            //->helperText('Breve descrição do produto.')
                            ->hintIcon('heroicon-m-question-mark-circle', tooltip: 'Digite uma breve descrição do produto, colocando suas características principais.')
                            ->columnSpanFull(),
                        Select::make('categories')
                            ->relationship('categories', 'name')
                            ->multiple()
                            ->columnSpanFull()
                            ->label('Categorias'),
                        Money::make('price')
                            ->label('Preço de Venda')
                            //->helperText('Preço de venda do produto. Ex.: 1,99')
                            ->hintIcon('heroicon-m-question-mark-circle', tooltip: 'Digite o preço de venda do produto. Ex.: 1,99')
                            ->required()
                            ->markAsRequired(),
                        ToggleButtons::make('active')
                            ->label('Produto está ativo?')
                            ->boolean()
                            ->default(1)
                            ->grouped(),
                    ]),
                Section::make('Dados de estoque:')
                    ->description('Dados referente ao controle de estoque do produto.')
                    ->icon('eos-storage-class-o')
                    ->collapsed()
                    ->columns(3)
                    ->schema([
                    TextInput::make('amount')
                        ->label('Estoque')
                        ->helperText('Quantidade em estoque.')
                        ->required()
                        ->markAsRequired(),
                    TextInput::make('minimum_amount')
                        ->label('Estoque Mínimo')
                        ->helperText('Quantidade mínima no estoque.')
                        ->required()
                        ->markAsRequired(),
                    TextInput::make('maximum_amount')
                        ->label('Estoque Máximo')
                        ->helperText('Quantidade máxima no estoque.')
                        ->required()
                        ->markAsRequired(),
                ]),
                FileUpload::make('photo')
                    ->label('Imagem do Produto')
                    ->columnSpanFull()
                    ->image()
                    ->imageEditor()
                    ->directory('products'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('photo')
                    ->square()
                    ->label('Imagem'),
                TextColumn::make('id')
                    ->label('Código')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('name')
                    ->label('Nome')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('price')
                    ->label('Preço')
                    ->prefix('R$ ')
                    ->sortable(),
                TextColumn::make('amount')
                    ->label('Estoque')
                    ->sortable(),
                TextColumn::make('minimum_amount')
                    ->label('Est. Mínimo')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('maximum_amount')
                    ->label('Est. Máximo')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                IconColumn::make('active')
                    ->label('Ativo ?')
                    ->boolean()
                    ->sortable(),
            ])
            ->filters([
                Filter::make('minimum_stock')
                    ->toggle()
                    ->query(fn (Builder $query): Builder => $query->orWhereRaw('amount < minimum_amount'))
                    ->label('Estoque abaixo do mínimo'),
                Filter::make('maximum_stock')
                    ->toggle()
                    ->query(fn (Builder $query): Builder => $query->orWhereRaw('amount > maximum_amount'))
                    ->label('Estoque acima do máximo'),
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
            ])
            ->defaultSort('name', 'ASC');
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }

    public static function getWidgets(): array
    {
        return [
            ProductsStatsOverview::class,
        ];
    }

    // public static function getNavigationBadge(): string
    // {
    //     return static::getModel()::count();
    // }
}

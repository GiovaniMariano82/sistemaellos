<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServiceResource\Pages;
use App\Filament\Resources\ServiceResource\RelationManagers;
use App\Filament\Resources\ServiceResource\Widgets\ServicesStatsOverview;
use App\Models\Service;
use App\Models\Unit;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\ActionSize;
use Filament\Support\RawJs;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;
use Leandrocfe\FilamentPtbrFormFields\Money;

class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;

    protected static ?string $navigationIcon = 'healthicons-o-call-centre';

    public static function getNavigationLabel(): string
    {
        return __('service.navigationLabel');
    }

    public static function getModelLabel(): string
    {
        return __('service.modelLabel');
    }

    public static function getPluralModelLabel(): string
    {
        return __('service.pluralModelLabel');
    }

    public static function getNavigationGroup(): string
    {
        return __('service.navigationGroup');
    }

    protected static ?int $navigationSort = 32;

    public static function form(Form $form): Form
    {
        return $form
            ->columns(2)
            ->schema([
                Section::make(__('service.section.title.personalData'))
                    ->description(__('service.section.description.personalData'))
                    ->icon('eos-description-o')
                    ->columns(4)
                    ->schema([
                        TextInput::make('id')
                            ->label(__('service.field.id'))
                            ->columnSpan(2)
                            ->disabled()
                            ->visibleOn(['edit', 'view']),
                        ToggleButtons::make('active')
                            ->label(__('service.field.active'))
                            ->boolean()
                            ->default(1)
                            ->grouped()
                            ->columnSpan(2),
                        TextInput::make('name')
                            ->label(__('service.field.name'))
                            ->autofocus()
                            ->required()
                            ->markAsRequired()
                            ->maxLength(100)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (string $operation, $state, Forms\Set $set) {
                                if ($operation !== 'create') {return;}
                                $set('slug', Str::slug($state));
                            })
                            ->columnSpanFull(),
                        TextInput::make('slug')
                            ->label(__('service.field.slug'))
                            ->disabled()
                            ->required()
                            ->maxLength(100)
                            ->dehydrated()
                            ->unique(Service::class, 'slug', ignoreRecord: true)
                            ->columnSpanFull(),
                        RichEditor::make('description')
                            ->label(__('service.field.description'))
                            ->columnSpanFull(),
                        Select::make('unit_id')
                            ->label(__('service.field.unit'))
                            ->options(Unit::where('active', '=', 1)->pluck('name', 'id'))
                            ->default(1)
                            ->required()
                            ->markAsRequired()
                            ->columnSpan(2),
                        Money::make('price')
                            ->label('Preço de Venda')
                            ->helperText(__('provider.helperText.documentNumber'))
                            ->required()
                            ->markAsRequired()
                            ->columnSpan(2),
                    ]),
                Section::make(__('service.section.title.extraData'))
                    ->description(__('service.section.description.extraData'))
                    ->icon('healthicons-f-i-documents-accepted')
                    ->collapsed()
                    ->visibleOn(['edit', 'view'])
                    ->columns(4)
                    ->schema([
                        DateTimePicker::make('created_at')
                            ->label(__('service.field.created_at'))
                            ->columnSpan(2)
                            ->disabled()
                            ->visibleOn(['edit', 'view']),
                        DateTimePicker::make('updated_at')
                            ->label(__('service.field.updated_at'))
                            ->columnSpan(2)
                            ->disabled()
                            ->visibleOn(['edit', 'view']),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label(__('service.column.id'))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('name')
                    ->label(__('service.column.name'))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('unit.acronym')
                    ->label(__('service.column.unit'))
                    ->badge(),
                TextColumn::make('price')
                    ->label(__('service.column.price'))
                    ->prefix('R$ ')
                    ->sortable(),
                IconColumn::make('active')
                    ->label(__('service.column.active'))
                    ->boolean()
                    ->sortable(),
            ])
            ->filters([
                Filter::make('services_active')
                    ->label(__('service.filter.show_active'))
                    ->toggle()
                    ->query(fn (Builder $query): Builder => $query->orWhere('active', 1))
                    ->default(false),
                Filter::make('services_inactive')
                    ->label(__('service.filter.show_inactive'))
                    ->toggle()
                    ->query(fn (Builder $query): Builder => $query->orWhere('active', 0))
                    ->default(false),
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
            'index' => Pages\ListServices::route('/'),
            'create' => Pages\CreateService::route('/create'),
            'edit' => Pages\EditService::route('/{record}/edit'),
        ];
    }

    public static function getWidgets(): array
    {
        return [
            ServicesStatsOverview::class,
        ];
    }
}

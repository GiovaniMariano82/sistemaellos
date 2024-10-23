<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProviderResource\Pages;
use App\Filament\Resources\ProviderResource\RelationManagers\ProviderContactsRelationManager;
use App\Filament\Resources\ProviderResource\Widgets\ProvidersStatsOverview;
use App\Models\{Provider,Status,TypeDocument,TypeGender, TypeProvider};
use Filament\Forms;
use Filament\Forms\Components\{DatePicker, DateTimePicker, RichEditor, Section, Select, TextInput};
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Leandrocfe\FilamentPtbrFormFields\Cep;

class ProviderResource extends Resource
{
    protected static ?string $model = Provider::class;

    protected static ?string $navigationIcon = 'healthicons-f-health-worker';

    protected static ?int $navigationSort = 2;

    public static function getNavigationLabel(): string
    {
        return __('provider.navigationLabel');
    }

    public static function getModelLabel(): string
    {
        return __('provider.modelLabel');
    }

    public static function getPluralModelLabel(): string
    {
        return __('provider.pluralModelLabel');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->columns(2)
            ->schema([
                Section::make(__('provider.section.title.personalData'))
                    ->description(__('provider.section.description.personalData'))
                    ->icon('eos-description-o')
                    ->columns(4)
                    ->schema([
                        TextInput::make('id')
                            ->label(__('provider.field.id'))
                            ->columnSpan(1)
                            ->disabled()
                            ->visibleOn(['edit', 'view']),
                        TextInput::make('fullName')
                            ->label(__('provider.field.fullName'))
                            ->autofocus()
                            ->required()
                            ->markAsRequired()
                            ->maxLength(100)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (string $operation, $state, Forms\Set $set) {
                                if ($operation !== 'create') {return;}
                                if(!mb_strstr( $state, ' ', true )) {return;}
                                $set('socialName', mb_strstr( $state, ' ', true ));
                            })
                            ->columnSpan(2),
                        TextInput::make('socialName')
                            ->label(__('provider.field.socialName'))
                            ->required()
                            ->markAsRequired()
                            ->maxLength(100)
                            ->dehydrated()
                            ->columnSpan(1),
                        Select::make('type_document_id')
                            ->id('type_document_id')
                            ->label(__('provider.field.typeDocument'))
                            ->options(TypeDocument::all()->pluck('name', 'id'))
                            ->default(1)
                            ->required()
                            ->markAsRequired()
                            ->columnSpan(1)
                            ->live(),
                        TextInput::make('documentNumber')
                            ->label(__('provider.field.documentNumber'))
                            ->required()
                            ->markAsRequired()
                            ->helperText(__('provider.helperText.documentNumber'))
                            ->maxLength(50)
                            ->mask(function (Get $get): string {
                                $valor = $get('type_document_id');
                                switch ($valor) {
                                    case 1:
                                        return '999.999.999-99';
                                    case 2:
                                        return '99.999.999/9999-99';
                                    default:
                                        return '';
                                }
                            })
                            ->columnSpan(1),
                        DatePicker::make('birthDate')
                            ->label(__('provider.field.birthDate'))
                            ->format('d/m/Y')
                            ->columnSpan(1),
                        Select::make('status_id')
                            ->label(__('provider.field.status'))
                            ->options(Status::where('active', '=', 1)->pluck('name', 'id'))
                            ->default(1)
                            ->required()
                            ->markAsRequired()
                            ->columnSpan(1),
                        DateTimePicker::make('created_at')
                            ->label(__('provider.field.createdAt'))
                            ->disabled()
                            ->visibleOn(['edit', 'view'])
                            ->columnSpan(1),
                            //->date('d/m/Y H:i:s'),
                        DateTimePicker::make('updated_at')
                            ->label(__('provider.field.updatedAt'))
                            ->disabled()
                            ->visibleOn(['edit', 'view'])
                            ->columnSpan(1),
                            //->date('d/m/Y H:i:s'),
                        TextInput::make('origin')
                            ->label(__('provider.field.origin'))
                            ->required()
                            ->disabled()
                            ->default('WEB')
                            ->columnSpan(1),
                        Select::make('type_gender_id')
                            ->label(__('provider.field.typeGender'))
                            ->options(TypeGender::all()->pluck('name', 'id'))
                            ->required()
                            ->markAsRequired()
                            ->columnSpan(1),
                        Select::make('type_provider_id')
                            ->label(__('provider.field.type_provider'))
                            ->options(TypeProvider::where('active', '=', 1)->pluck('name', 'id'))
                            ->required()
                            ->markAsRequired()
                            ->columnSpan(1),
                    ]),
                Section::make(__('provider.section.title.addressData'))
                    ->description(__('provider.section.description.addressData'))
                    ->icon('healthicons-f-home')
                    ->columns(4)
                    //->collapsed()
                    ->schema([
                        Cep::make('postalCode')
                            ->label(__('provider.field.postalCode'))
                            ->required()
                            ->markAsRequired()
                            ->columnSpan(1)
                            //->live(onBlur: true)
                            ->viaCep(
                                mode: 'suffix', // Determines whether the action should be appended to (suffix) or prepended to (prefix) the cep field, or not included at all (none).
                                errorMessage: 'CEP inválido.', // Error message to display if the CEP is invalid.

                                /**
                                 * Other form fields that can be filled by ViaCep.
                                 * The key is the name of the Filament input, and the value is the ViaCep attribute that corresponds to it.
                                 * More information: https://viacep.com.br/
                                 */
                                setFields: [
                                    'address' => 'logradouro',
                                    //'addressNumber' => 'numero',
                                    'complement' => 'complemento',
                                    'neighborhood' => 'bairro',
                                    'city' => 'localidade',
                                    'state' => 'uf'
                                ]
                            ),
                        TextInput::make('address')
                            ->label(__('provider.field.address'))
                            ->required()
                            ->markAsRequired()
                            ->maxLength(100)
                            ->columnSpan(2),
                        TextInput::make('addressNumber')
                            ->label(__('provider.field.addressNumber'))
                            ->maxLength(10)
                            ->columnSpan(1),
                        TextInput::make('complement')
                            ->label(__('provider.field.complement'))
                            ->maxLength(50)
                            ->columnSpan(1),
                        TextInput::make('neighborhood')
                            ->label(__('provider.field.neighborhood'))
                            ->required()
                            ->maxLength(50)
                            ->markAsRequired()
                            ->columnSpan(1),
                        TextInput::make('city')
                            ->label(__('provider.field.city'))
                            ->required()
                            ->markAsRequired()
                            ->maxLength(50)
                            ->columnSpan(1),
                        TextInput::make('state')
                            ->label(__('provider.field.state'))
                            ->required()
                            ->markAsRequired()
                            ->maxLength(2)
                            ->columnSpan(1),
                    ]),
                Section::make(__('provider.section.title.extraData'))
                    ->description(__('provider.section.description.extraData'))
                    ->icon('healthicons-f-i-documents-accepted')
                    ->collapsed()
                    ->schema([
                        RichEditor::make('observation')
                            ->label(__('provider.field.observation')),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label(__('provider.column.id'))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('fullName')
                    ->label(__('provider.column.fullName'))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('socialName')
                    ->label(__('provider.column.socialName'))
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('type_provider.name')
                    ->label(__('provider.column.type_provider'))
                    ->sortable(),
                TextColumn::make('status.name')
                    ->label(__('provider.column.status'))
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Ativo' => 'success',
                        'Inativo' => 'danger',
                    }),
            ])
            ->filters([
                Filter::make('providers_active')
                    ->label(__('provider.filter.show_active'))
                    ->toggle()
                    ->query(fn (Builder $query): Builder => $query->orWhere('status_id', 1))
                    ->default(true),
                Filter::make('providers_inactive')
                    ->label(__('provider.filter.show_inactive'))
                    ->toggle()
                    ->query(fn (Builder $query): Builder => $query->orWhere('status_id', 2))
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
            ]);
    }

    public static function getRelations(): array
    {
        return [
            ProviderContactsRelationManager::class,
        ];
    }

    public static function getWidgets(): array
    {
        return [
            ProvidersStatsOverview::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProviders::route('/'),
            'create' => Pages\CreateProvider::route('/create'),
            'view' => Pages\ViewProvider::route('/{record}'),
            'edit' => Pages\EditProvider::route('/{record}/edit'),
        ];
    }
}

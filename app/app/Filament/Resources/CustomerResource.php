<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerResource\Pages;
use App\Filament\Resources\CustomerResource\RelationManagers\ContactsRelationManager;
use App\Filament\Resources\CustomerResource\Widgets\CustomersStatsOverview;
use App\Models\{Customer,Status,TypeDocument,TypeGender};
use DateTime;
use Filament\Forms;
use Filament\Forms\Components\{DatePicker, DateTimePicker, RichEditor, Section, Select, TextInput};
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Leandrocfe\FilamentPtbrFormFields\Cep;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?string $navigationIcon = 'eos-supervised-user-circle-o';

    protected static ?int $navigationSort = 1;

    public static function getNavigationLabel(): string
    {
        return __('customer.navigationLabel');
    }

    public static function getModelLabel(): string
    {
        return __('customer.modelLabel');
    }

    public static function getPluralModelLabel(): string
    {
        return __('customer.pluralModelLabel');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->columns(2)
            ->schema([
                Section::make(__('customer.section.title.personalData'))
                    ->description(__('customer.section.description.personalData'))
                    ->icon('eos-description-o')
                    ->columns(4)
                    ->schema([
                        TextInput::make('id')
                            ->label(__('customer.field.id'))
                            ->columnSpan(1)
                            ->disabled()
                            ->visibleOn(['edit', 'view']),
                        TextInput::make('fullName')
                            ->label(__('customer.field.fullName'))
                            ->autofocus()
                            ->required()
                            ->markAsRequired()
                            ->maxLength(100)
                            ->live()
                            ->afterStateUpdated(function (string $operation, $state, Forms\Set $set) {
                                if ($operation !== 'create') {return;}
                                $set('socialName', mb_strstr( $state, ' ', true ));
                            })
                            ->columnSpan(2),
                        TextInput::make('socialName')
                            ->label(__('customer.field.socialName'))
                            ->required()
                            ->markAsRequired()
                            ->maxLength(100)
                            ->dehydrated()
                            ->columnSpan(1),
                        Select::make('type_document_id')
                            ->id('type_document_id')
                            ->label(__('customer.field.typeDocument'))
                            ->options(TypeDocument::all()->pluck('name', 'id'))
                            ->default(1)
                            ->required()
                            ->markAsRequired()
                            ->columnSpan(1)
                            ->live(),
                        TextInput::make('documentNumber')
                            ->label(__('customer.field.documentNumber'))
                            ->required()
                            ->markAsRequired()
                            ->helperText(__('customer.helperText.documentNumber'))
                            ->maxLength(50)
                            ->mask(function (Get $get): string {
                                $valor = $get('type_document_id');
                                return match ($valor) {
                                    '1' => '999.999.999-99',
                                    '2' => '99.999.999/9999-99',
                                    default => '',
                                };
                            })
                            ->columnSpan(1),
                        DatePicker::make('birthDate')
                            ->label(__('customer.field.birthDate'))
                            ->format('d/m/Y')
                            ->columnSpan(1)
                            ->live(true)
                            ->afterStateUpdated(function ($state, Forms\Set $set){
                                $date = new DateTime($state );
                                $interval = $date->diff( new DateTime( date('Y-m-d') ) );
                                $set('customer_age', $interval->format( '%Y anos' ));
                            }),
                        TextInput::make('customer_age')
                            ->label(__('customer.field.customer_age'))
                            ->disabled()
                            ->default('0')
                            ->columnSpan(1),
                        Select::make('type_gender_id')
                            ->label(__('customer.field.typeGender'))
                            ->options(TypeGender::all()->pluck('name', 'id'))
                            ->required()
                            ->markAsRequired()
                            ->columnSpan(1),
                        Select::make('status_id')
                            ->label(__('customer.field.status'))
                            ->options(Status::where('active', '=', 1)->pluck('name', 'id'))
                            ->default(1)
                            ->required()
                            ->markAsRequired()
                            ->columnSpan(1),
                        TextInput::make('origin')
                            ->label(__('customer.field.origin'))
                            ->required()
                            ->disabled()
                            ->default('WEB')
                            ->columnSpan(1),
                    ]),
                Section::make(__('customer.section.title.addressData'))
                    ->description(__('customer.section.description.addressData'))
                    ->icon('healthicons-f-home')
                    ->columns(4)
                    //->collapsed()
                    ->schema([
                        Cep::make('postalCode')
                            ->label(__('customer.field.postalCode'))
                            ->markAsRequired()
                            ->columnSpan(1)
                            ->viaCep(
                                mode: 'suffix',
                                errorMessage: 'CEP inválido.',
                                setFields: [
                                    'address' => 'logradouro',
                                    //'addressNumber' => 'numero',
                                    'complement' => 'complemento',
                                    'neighborhood' => 'bairro',
                                    'city' => 'localidade',
                                    'state' => 'uf'
                                ],
                            ),
                        TextInput::make('address')
                            ->label(__('customer.field.address'))
                            ->required()
                            ->markAsRequired()
                            ->maxLength(100)
                            ->columnSpan(2),
                        TextInput::make('addressNumber')
                            ->label(__('customer.field.addressNumber'))
                            ->maxLength(10)
                            ->columnSpan(1),
                        TextInput::make('complement')
                            ->label(__('customer.field.complement'))
                            ->maxLength(50)
                            ->columnSpan(1),
                        TextInput::make('neighborhood')
                            ->label(__('customer.field.neighborhood'))
                            ->required()
                            ->maxLength(50)
                            ->markAsRequired()
                            ->columnSpan(1),
                        TextInput::make('city')
                            ->label(__('customer.field.city'))
                            ->required()
                            ->markAsRequired()
                            ->maxLength(50)
                            ->columnSpan(1),
                        TextInput::make('state')
                            ->label(__('customer.field.state'))
                            ->required()
                            ->markAsRequired()
                            ->maxLength(2)
                            ->columnSpan(1),
                    ]),
                Section::make(__('customer.section.title.extraData'))
                    ->description(__('customer.section.description.extraData'))
                    ->icon('healthicons-f-i-documents-accepted')
                    ->collapsed()
                    ->columns(2)
                    ->schema([
                        RichEditor::make('observation')
                            ->label(__('customer.field.observation'))
                            ->columnSpanFull(),
                        DateTimePicker::make('created_at')
                            ->label(__('customer.field.createdAt'))
                            ->disabled()
                            ->visibleOn(['edit', 'view'])
                            ->columnSpan(1),
                            //->date('d/m/Y H:i:s'),
                        DateTimePicker::make('updated_at')
                            ->label(__('customer.field.updatedAt'))
                            ->disabled()
                            ->visibleOn(['edit', 'view'])
                            ->columnSpan(1),
                            //->date('d/m/Y H:i:s'),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label(__('customer.column.id'))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('fullName')
                    ->label(__('customer.column.fullName'))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('socialName')
                    ->label(__('customer.column.socialName'))
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('type_document.name')
                    ->label(__('customer.column.type_document'))
                    ->badge()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('documentNumber')
                    ->label(__('customer.column.documentNumber'))
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('status.name')
                    ->label(__('customer.column.status'))
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Ativo' => 'success',
                        'Inativo' => 'danger',
                    }),
            ])
            ->filters([
                Filter::make('customers_active')
                    ->label(__('customer.filter.show_active'))
                    ->toggle()
                    ->query(fn (Builder $query): Builder => $query->orWhere('status_id', 1))
                    ->default(true),
                Filter::make('customers_inactive')
                    ->label(__('customer.filter.show_inactive'))
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
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\Action::make('medical_record')
                        ->label('Prontuário do Paciente')
                        ->color(Color::Blue)
                        ->icon('healthicons-f-health-worker-form')
                        ->url(fn (): string => route('filament.admin.resources.customers.medical', ['record' => '1' ]))
                ])->color(Color::Gray),
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
            ContactsRelationManager::class,
        ];
    }

    public static function getWidgets(): array
    {
        return [
            CustomersStatsOverview::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'view' => Pages\ViewCustomer::route('/{record}'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
            'medical' => Pages\MedicalRecordCustomers::route('/{record}/medical'),
        ];
    }
}

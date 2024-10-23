<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RegisterCustomerResource\Pages;
use App\Filament\Resources\RegisterCustomerResource\RelationManagers;
use App\Filament\Resources\RegisterCustomerResource\Widgets\RegisterCustomerOverview;
use App\Models\Customer;
use App\Models\RegisterCustomer;
use App\Models\Service;
use Filament\Forms;
use Filament\Forms\Components\Actions;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Carbon\Carbon;
use Filament\Forms\Components\Actions\Action as ActionsAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Set;
use Filament\Support\Enums\VerticalAlignment;
use Leandrocfe\FilamentPtbrFormFields\Money;


class RegisterCustomerResource extends Resource
{
    protected static ?string $model = RegisterCustomer::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    public static function getNavigationGroup(): ?string
    {
        return __('register_customer.navigationGroup');
    }

    public static function getNavigationLabel(): string
    {
        return __('register_customer.navigationLabel');
    }

    public static function getModelLabel(): string
    {
        return __('register_customer.modelLabel');
    }

    public static function getPluralModelLabel(): string
    {
        return __('register_customer.pluralModelLabel');
    }

    protected static ?int $navigationSort = 33;

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
                    Hidden::make('amount_service_unit')->default(0),
                    TextInput::make('id')
                        ->label(__('customer.field.id'))
                        ->columnSpan(1)
                        ->disabled()
                        ->visibleOn(['edit', 'view']),
                    Select::make('customer_id')
                        ->label(__('Nome do cliente'))
                        ->relationship('customer', 'fullName')
                        ->preload()
                        ->required()
                        ->markAsRequired()
                        ->searchable()
                        ->columnSpan(fn(string $operation) => $operation === 'create' ? 4 : 3),
                    Select::make('provider_id')
                        ->label(__('Nome do Instrutor'))
                        ->relationship('provider', 'fullName')
                        ->required()
                        ->preload()
                        ->markAsRequired()
                        ->searchable()
                        ->columnSpan(2),
                    Select::make('service_id')
                        ->label(__('Serviço escolhido'))
                        ->relationship('service', 'name')
                        ->required()
                        ->markAsRequired()
                        ->columnSpan(2)
                        ->live()
                        ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
                            $service = Service::where('id', '=', intval($state))->first();
                            $set('amount_service_unit', $service['price']);

                            $valorServico = floatval(str_replace(",", ".", $service['price']));

                            $duracao = intval($get('duration'));
                            if($duracao > 1)
                            {
                                $valorServico *= $duracao;
                            }

                            $set('amount_service', number_format($valorServico, 2, ',', ''));

                            $percentDesconto = floatval($get('discount_percent'));
                            if($percentDesconto < 0 || $percentDesconto > 100)
                            {
                                $set('amount_to_pay', $valorServico);
                                return;
                            }

                            $percentDesconto /= 100;


                            $valorDesconto = $valorServico*$percentDesconto;
                            $valorPago = $valorServico - $valorDesconto;

                            $set('discount_value', number_format($valorDesconto, 2, ',', ''));
                            $set('amount_to_pay', number_format($valorPago, 2, ',', ''));

                            //$set('split_pay', 0);
                            //$set('amount_split_pay', number_format(0, 2, ',', ''));

                            $quantVezes = intval($get('split_pay'));

                            if ($quantVezes < 1 || $quantVezes > 24) {return;}

                            $valorParcela = $valorPago/$quantVezes;
                            $set('amount_split_pay', number_format($valorParcela, 2, ',', ''));
                        }),
                    TextInput::make('duration')
                        ->label(__('Tempo de contrato (Mês)'))
                        ->numeric()
                        ->maxValue(24)
                        ->minValue(1)
                        ->default(1)
                        ->columnSpan(1)
                        ->live($onBlur = true)
                        ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
                            $duracao = intval($state);

                            if ($duracao < 1 || $duracao > 24) {return;}

                            $data_final = Carbon::createFromFormat('Y-m-d', $get('start_date'))->add($duracao, 'month');
                            $set('end_date', $data_final->format('Y-m-d'));

                            $valorServico = floatval(str_replace(",", ".", $get('amount_service_unit')));


                            if($duracao > 1)
                            {
                                $valorServico *= $duracao;
                            }

                            $set('amount_service', number_format($valorServico, 2, ',', ''));

                            $percentDesconto = floatval($get('discount_percent'));
                            if($percentDesconto < 0 || $percentDesconto > 100)
                            {
                                $set('amount_to_pay', $valorServico);
                                return;
                            }

                            $percentDesconto /= 100;


                            $valorDesconto = $valorServico*$percentDesconto;
                            $valorPago = $valorServico - $valorDesconto;

                            $set('discount_value', number_format($valorDesconto, 2, ',', ''));
                            $set('amount_to_pay', number_format($valorPago, 2, ',', ''));

                            $set('split_pay', 0);
                            $set('amount_split_pay', number_format(0, 2, ',', ''));

                            $quantVezes = intval($get('split_pay'));

                            if ($quantVezes < 1 || $quantVezes > 24) {return;}

                            $valorParcela = $valorPago/$quantVezes;
                            $set('amount_split_pay', number_format($valorParcela, 2, ',', ''));
                        }),
                    DatePicker::make('start_date')
                        ->label(__('Data Inicial'))
                        ->format('d/m/Y')
                        ->default(now())
                        ->columnSpan(1)
                        ->live($onBlur = true)
                        ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
                            $quantMes = intval($get('duration'));

                            if ($quantMes < 1 || $quantMes > 24) {return;}

                            $data_final = Carbon::createFromFormat('Y-m-d', $state)->add($quantMes, 'month');
                            $set('end_date', $data_final->format('Y-m-d'));
                        }),
                    DatePicker::make('end_date')
                        ->label(__('Data Final'))
                        ->format('d/m/Y')
                        ->default(now())
                        ->columnSpan(1),
                    ToggleButtons::make('active')
                        ->label(__('Matrícula Ativa ?'))
                        ->boolean()
                        ->default(1)
                        ->grouped()
                        ->columnSpan(1),
                ]),
            Section::make(__('Dados de pagamento'))
                ->description(__('customer.section.description.personalData'))
                ->icon('eos-monetization-on')
                ->columns(4)
                ->schema([
                    Money::make('amount_service')
                        ->label('Valor do Serviço')
                        ->required()
                        ->markAsRequired()
                        ->columnSpan(1)
                        //->disabled(true)
                        ->readOnly(true)
                        ->live()
                        ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
                            dd($state);
                        }),
                    TextInput::make('discount_percent')
                        ->label(__('Desconto'))
                        ->postfix('%')
                        ->numeric()
                        ->maxValue(100)
                        ->minValue(0)
                        ->default(0)
                        ->step(0.5)
                        ->columnSpan(1)
                        ->live($onBlur = true)
                        ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
                            $percentDesconto = $state/100;
                            $valorServico = floatval(str_replace(",", ".", $get('amount_service')));
                            $valorDesconto = $valorServico*$percentDesconto;
                            $valorPago = $valorServico - $valorDesconto;
                            $set('discount_value', number_format($valorDesconto, 2, ',', ''));
                            $set('amount_to_pay', number_format($valorPago, 2, ',', ''));

                            $quantVezes = intval($get('split_pay'));

                            if ($quantVezes < 1 || $quantVezes > 24) {return;}

                            $valorParcela = $valorPago/$quantVezes;
                            $set('amount_split_pay', number_format($valorParcela, 2, ',', ''));
                        }),
                    Money::make('discount_value')
                        ->label('Valor de Desconto')
                        ->required()
                        ->markAsRequired()
                        ->columnSpan(1)
                        //->disabled(true),
                        ->readOnly(true),
                    Money::make('amount_to_pay')
                        ->label('Valor Pago')
                        ->required()
                        ->markAsRequired()
                        ->columnSpan(1)
                        //->disabled(true)
                        ->readOnly(true),
                    TextInput::make('split_pay')
                        ->label(__('Parcelado em:'))
                        ->prefix('X')
                        ->numeric()
                        ->maxValue(24)
                        ->minValue(1)
                        ->default(0)
                        ->columnSpan(1)
                        ->live($onBlur = true)
                        ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
                            $quantVezes = intval($state);

                            if ($quantVezes < 1 || $quantVezes > 24) {return;}

                            $valorPago = floatval(str_replace(",", ".", $get('amount_to_pay')));
                            $valorParcela = $valorPago/$quantVezes;

                            $set('amount_split_pay', number_format($valorParcela, 2, ',', ''));
                        }),
                    Money::make('amount_split_pay')
                        ->label('Valor Parcela')
                        ->required()
                        ->markAsRequired()
                        ->columnSpan(1)
                        //->disabled(true)
                        ->readOnly(true),
                    Select::make('payment_method_id')
                        ->label(__('Forma de Pagamento'))
                        ->relationship('payment_method', 'name')
                        ->required()
                        ->markAsRequired()
                        ->columnSpan(1),
                    // Actions::make([
                    //     Action::make('star')
                    //         ->icon('heroicon-m-star')
                    //         ->requiresConfirmation(),
                    //     Action::make('resetStars')
                    //         ->icon('heroicon-m-x-mark')
                    //         ->color('danger')
                    //         ->requiresConfirmation(),
                    //     ])->fullWidth()->verticalAlignment(VerticalAlignment::End),
                ]),
            Section::make(__('customer.section.title.extraData'))
                ->description(__('customer.section.description.extraData'))
                ->icon('healthicons-f-i-documents-accepted')
                ->columns(2)
                ->schema([
                    RichEditor::make('observation')
                        ->label(__('customer.field.observation'))
                        ->columnSpanFull(),
                    DateTimePicker::make('created_at')
                        ->label(__('payment_method.field.created_at'))
                        ->disabled()
                        ->visibleOn(['edit', 'view'])
                        ->columnSpan(1),
                    DateTimePicker::make('updated_at')
                        ->label(__('payment_method.field.updated_at'))
                        ->disabled()
                        ->visibleOn(['edit', 'view'])
                        ->columnSpan(1),
                ])
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label(__('register_customer.column.id'))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('customer.socialName')
                    ->label(__('register_customer.column.customer'))
                    ->description(fn ($record): string => $record->customer->fullName)
                    ->url(fn ($record): string => route('filament.admin.resources.customers.view', ['record' => $record->customer]))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('service.name')
                    ->label(__('register_customer.column.service'))
                    //->url(fn ($record): string => route('filament.admin.resources.services.edit', ['record' => $record->service]))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('provider.socialName')
                    //->description(fn ($record): string => $record->provider->fullName)
                    //->url(fn ($record): string => route('filament.admin.resources.providers.edit', ['record' => $record->provider]))
                    ->label(__('register_customer.column.provider'))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('start_date')
                    ->date('d/m/Y')
                    ->label(__('register_customer.column.start_date'))
                    ->sortable(),
                TextColumn::make('end_date')
                    ->date('d/m/Y')
                    ->label(__('register_customer.column.end_date'))
                    ->sortable(),
                IconColumn::make('active')
                    ->label('Ativo ?')
                    ->boolean()
                    ->sortable(),
            ])
            ->filters([
                Filter::make('register_active')
                    ->label(__('customer.filter.show_active'))
                    ->toggle()
                    ->query(fn (Builder $query): Builder => $query->orWhere('active', 1))
                    ->default(true),
                Filter::make('register_inactive')
                    ->label(__('customer.filter.show_inactive'))
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
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getWidgets(): array
    {
        return [
            RegisterCustomerOverview::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRegisterCustomers::route('/'),
            'create' => Pages\CreateRegisterCustomer::route('/create'),
            'edit' => Pages\EditRegisterCustomer::route('/{record}/edit'),
        ];
    }
}

<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PaymentMethodResource\Pages;
use App\Filament\Resources\PaymentMethodResource\RelationManagers;
use App\Models\PaymentMethod;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class PaymentMethodResource extends Resource
{
    protected static ?string $model = PaymentMethod::class;

    protected static ?string $navigationIcon = 'eos-monetization-on-o';

    public static function getNavigationGroup(): ?string
    {
        return __('payment_method.navigationGroup');
    }

    protected static ?int $navigationSort = 48;

    public static function getNavigationLabel(): string
    {
        return __('payment_method.navigationLabel');
    }

    public static function getModelLabel(): string
    {
        return __('payment_method.modelLabel');
    }

    public static function getPluralModelLabel(): string
    {
        return __('payment_method.pluralModelLabel');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->columns(2)
            ->schema([
                Section::make(__('payment_method.section.title.personalData'))
                    ->description(__('payment_method.section.description.personalData'))
                    ->icon('eos-description-o')
                    ->collapsible()
                    ->columns(4)
                    ->schema([
                        TextInput::make('id')
                            ->label(__('payment_method.field.id'))
                            ->columnSpan(1)
                            ->disabled()
                            ->visibleOn(['edit', 'view']),
                        TextInput::make('name')
                            ->label(__('payment_method.field.name'))
                            ->autofocus()
                            ->required()
                            ->markAsRequired()
                            ->columnSpan(3),
                        Textarea::make('description')
                            ->label(__('payment_method.field.description'))
                            ->required()
                            ->markAsRequired()
                            ->maxLength(255)
                            ->columnSpanFull(),
                        ToggleButtons::make('has_input_box')
                            ->label(__('payment_method.field.has_input_box'))
                            ->boolean()
                            ->default(1)
                            ->grouped()
                            ->columnSpan(2),
                        ToggleButtons::make('active')
                            ->label(__('payment_method.field.active'))
                            ->boolean()
                            ->default(1)
                            ->grouped()
                            ->columnSpan(2),
                        DateTimePicker::make('created_at')
                            ->label(__('payment_method.field.created_at'))
                            ->disabled()
                            ->visibleOn(['edit', 'view'])
                            ->columnSpan(2),
                        DateTimePicker::make('updated_at')
                            ->label(__('payment_method.field.updated_at'))
                            ->disabled()
                            ->visibleOn(['edit', 'view'])
                            ->columnSpan(2),
                    ]
                ),
            ]
        );
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label(__('payment_method.column.id'))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('name')
                    ->label(__('payment_method.column.name'))
                    ->sortable()
                    ->searchable(),
                IconColumn::make('has_input_box')
                    ->label(__('payment_method.column.has_input_box'))
                    ->boolean()
                    ->sortable(),
                IconColumn::make('active')
                    ->label(__('payment_method.column.active'))
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
                    ->button()
                    ->before(function(Tables\Actions\DeleteAction $action, Model $record){
                        if($record->register_customers()->count() > 0)
                        {
                            Notification::make()
                                ->danger()
                                ->title('Erro ao Excluir')
                                ->body('Método de pagamento está em uso.')
                                ->send();

                            $action->halt();
                        }
                    })
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
            'index' => Pages\ListPaymentMethods::route('/'),
            //'create' => Pages\CreatePaymentMethod::route('/create'),
            //'edit' => Pages\EditPaymentMethod::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): string
    {
        return static::getModel()::count();
    }
}

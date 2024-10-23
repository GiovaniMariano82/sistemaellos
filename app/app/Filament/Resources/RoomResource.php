<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RoomResource\Pages;
use App\Filament\Resources\RoomResource\RelationManagers;
use App\Models\Room;
use App\Models\TypeRoom;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RoomResource extends Resource
{
    protected static ?string $model = Room::class;

    protected static ?string $navigationIcon = 'healthicons-o-physical-therapy';

    public static function getNavigationGroup(): ?string
    {
        return __('room.navigationGroup');
    }

    protected static ?int $navigationSort = 40;

    public static function getNavigationLabel(): string
    {
        return __('room.navigationLabel');
    }

    public static function getModelLabel(): string
    {
        return __('room.modelLabel');
    }

    public static function getPluralModelLabel(): string
    {
        return __('room.pluralModelLabel');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->columns(2)
            ->schema([
                Section::make(__('room.section.title.personalData'))
                    ->description(__('room.section.description.personalData'))
                    ->icon('eos-description-o')
                    ->columns(4)
                    ->schema([
                        TextInput::make('id')
                            ->label(__('room.field.id'))
                            ->columnSpan(1)
                            ->disabled()
                            ->visibleOn(['edit', 'view']),
                        TextInput::make('name')
                            ->label(__('room.field.name'))
                            ->required()
                            ->markAsRequired()
                            ->maxLength(100)
                            ->columnSpan(2),
                        ToggleButtons::make('active')
                            ->label(__('room.field.active'))
                            ->boolean()
                            ->default(1)
                            ->grouped()
                            ->columnSpan(1),
                        Textarea::make('description')
                            ->label(__('room.field.description'))
                            ->required()
                            ->markAsRequired()
                            ->maxLength(255)
                            ->columnSpanFull(),
                        Select::make('type_room_id')
                            ->label(__('room.field.type_room'))
                            ->options(TypeRoom::where('active', '=', 1)->pluck('name', 'id'))
                            ->required()
                            ->markAsRequired()
                            ->columnSpan(2),
                        TextInput::make('customer_limit')
                            ->label(__('room.field.customer_limit'))
                            ->numeric()
                            ->default(0)
                            ->required()
                            ->markAsRequired()
                            ->columnSpan(2),
                        DateTimePicker::make('created_at')
                            ->label(__('room.field.created_at'))
                            ->disabled()
                            ->visibleOn(['edit', 'view'])
                            ->columnSpan(2),
                        DateTimePicker::make('updated_at')
                            ->label(__('room.field.updated_at'))
                            ->disabled()
                            ->visibleOn(['edit', 'view'])
                            ->columnSpan(2),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label(__('room.column.id'))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('name')
                    ->label(__('room.column.name'))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('type_room.name')
                    ->label(__('room.column.type_room'))
                    ->sortable(),
                TextColumn::make('customer_limit')
                    ->label(__('room.column.customer_limit')),
                IconColumn::make('active')
                    ->label(__('room.column.active'))
                    ->boolean()
                    ->sortable(),
            ])
            ->filters([
                Filter::make('rooms_active')
                    ->label(__('customer.filter.show_active'))
                    ->toggle()
                    ->query(fn (Builder $query): Builder => $query->orWhere('active', 1))
                    ->default(true),
                Filter::make('rooms_inactive')
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRooms::route('/'),
            'create' => Pages\CreateRoom::route('/create'),
            'edit' => Pages\EditRoom::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): string
    {
        return static::getModel()::count();
    }
}

<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TypeRoomResource\Pages;
use App\Filament\Resources\TypeRoomResource\RelationManagers;
use App\Models\TypeRoom;
use Filament\Forms;
use Filament\Forms\Components\{DateTimePicker, Section, TextInput, ToggleButtons};
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TypeRoomResource extends Resource
{
    protected static ?string $model = TypeRoom::class;

    protected static ?string $navigationIcon = 'eos-room-preferences';

    public static function getNavigationGroup(): ?string
    {
        return __('type_room.navigationGroup');
    }

    protected static ?int $navigationSort = 47;

    public static function getNavigationLabel(): string
    {
        return __('type_room.navigationLabel');
    }

    public static function getModelLabel(): string
    {
        return __('type_room.modelLabel');
    }

    public static function getPluralModelLabel(): string
    {
        return __('type_room.pluralModelLabel');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->columns(2)
            ->schema([
                Section::make(__('type_room.section.title.personalData'))
                    ->description(__('type_room.section.description.personalData'))
                    ->icon('eos-description-o')
                    ->collapsible()
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->label(__('type_room.field.name'))
                            ->autofocus()
                            ->required()
                            ->markAsRequired()
                            ->columnSpanFull(),
                        ToggleButtons::make('active')
                            ->label(__('type_room.field.active'))
                            ->boolean()
                            ->default(1)
                            ->grouped(),
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
                    ->label(__('type_room.column.id'))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('name')
                    ->label(__('type_room.column.name'))
                    ->sortable()
                    ->searchable(),
                IconColumn::make('active')
                    ->label(__('type_room.column.active'))
                    ->boolean()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label(__('type_room.column.created_at'))
                    ->date('d/m/Y H:i:s')
                    ->sortable(),
                TextColumn::make('updated_at')
                    ->label(__('type_room.column.updated_at'))
                    ->date('d/m/Y H:i:s')
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
            'index' => Pages\ListTypeRooms::route('/'),
            //'create' => Pages\CreateTypeRoom::route('/create'),
            //'edit' => Pages\EditTypeRoom::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): string
    {
        return static::getModel()::count();
    }
}

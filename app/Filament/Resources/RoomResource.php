<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Room;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Grid;
use Filament\Support\Enums\MaxWidth;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Filters\TernaryFilter;
use App\Filament\Resources\RoomResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\RoomResource\RelationManagers;

class RoomResource extends Resource
{
    protected static ?string $model = Room::class;


    protected static ?string $navigationIcon = 'icon-hotel';
    protected static ?int $navigationSort = 7;

    public static function getModelLabel(): string
    {
        return __('Room');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Rooms');
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make()->schema([
                    Section::make(__('Main Information'))
                        ->description(__('This is the main information about the room'))
                        ->collapsible(true)
                        ->schema([
                            TextInput::make('number')
                                ->label(__('Room Number'))
                                ->unique(Room::class, 'number', ignoreRecord: true)
                                ->minValue(1)
                                ->numeric()
                                ->required(),


                            Select::make('type')
                                ->label(__('Room Type'))
                                ->options([
                                    'single' => __('Single'),
                                    'double' => __('Double'),
                                    'suite' => __('Suite'),

                                ]),


                            TextInput::make('price_per_night')
                                ->label(__('Price Per Night'))
                                ->minValue(1)
                                ->numeric()
                                ->inputMode('decimal')
                                ->required(),

                        ])->columns(1),





                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->emptyStateHeading(__('No Rooms Found'))
            ->emptyStateDescription(__('Try creating a new room.'))
            ->emptyStateIcon('icon-hotel')
            ->striped()
            ->heading(__('Rooms'))
            ->description(__('Here you can view all rooms'))
            ->modifyQueryUsing(function (Builder $query) {
                return $query->latest('created_at');
            })
            ->columns([
                TextColumn::make('number')
                    ->badge()
                    ->label(__('Room Number'))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('type')
                    ->label(__('Room Type'))
                    ->sortable()
                    ->badge()
                    ->searchable()
                    ->color(function (string $state): string {
                        return match ($state) {
                            'single' => 'success',
                            'double' => 'primary',
                            'suite' => 'warning',
                        };
                    })
                    ->formatStateUsing(function (string $state): string {
                        return match ($state) {
                            'single' => __('Single'),
                            'double' => __('Double'),
                            'suite' => __('Suite'),
                        };
                    }),
                TextColumn::make('price_per_night')
                    ->label(__('Price Per Night'))
                    ->money('EGP')
                    ->sortable()
                    ->searchable(),
                // ->toggleable(isToggledHiddenByDefault: true),

                ToggleColumn::make('is_available')
                    ->label(__('Is Available')),


                TextColumn::make('created_at')
                    ->label(__('Created At'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

            ])
            ->filters([
                // TrashedFilter::make(),
                SelectFilter::make('type')
                    ->label(__('Room Type'))
                    ->options([
                        'single' => __('Single'),
                        'double' => __('Double'),
                        'suite' => __('Suite'),
                    ]),
                    TernaryFilter::make('is_available')
                    ->label(__('Is Available'))
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make()->slideOver()->modalWidth(MaxWidth::Large)->successNotificationTitle(__('Room updated successfully')),
                    Tables\Actions\DeleteAction::make(),

                ]),
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
            // 'create' => Pages\CreateRoom::route('/create'),
            // 'edit' => Pages\EditRoom::route('/{record}/edit'),
        ];
    }
}

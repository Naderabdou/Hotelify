<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\UserResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\UserResource\RelationManagers;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'icon-students';
    protected static ?int $navigationSort = 5;

    public static function getModelLabel(): string
    {
        return __('User');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Users');
    }

    // public static function form(Form $form): Form
    // {
    //     return $form
    //         ->schema([
    //             //
    //         ]);
    // }

    public static function table(Table $table): Table
    {

        return $table
            ->emptyStateHeading(__('No Users'))
            ->emptyStateDescription(__('Try creating a new user.'))
            ->emptyStateIcon('icon-students')
            ->striped()
            ->heading(__('Users'))
            ->description(__('This is the list of all users'))
            ->modifyQueryUsing(function (Builder $query) {
                return $query->latest('created_at')->role('user');
            })
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->default('N/A')
                    ->label(__('Name'))
                    ->sortable(),

                TextColumn::make('email')
                    ->searchable()
                    ->default('N/A')
                    ->label(__('Email'))
                    ->sortable(),
             //




                TextColumn::make('created_at')
                    ->label(__('Registered At'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),


            ])
            // ->filters([
            //     //
            // ])
            // ->actions([
            //     Tables\Actions\EditAction::make(),
            // ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}

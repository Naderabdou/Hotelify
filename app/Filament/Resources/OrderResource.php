<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Order;
use App\Models\Booking;
use Filament\Forms\Get;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\Fieldset;
use Filament\Infolists\Components\TextEntry;
use App\Filament\Resources\OrderResource\Pages;


class OrderResource extends Resource
{
    protected static ?string $model = Booking::class;

    protected static ?string $navigationIcon = 'icon-online_order';

    protected static ?int $navigationSort = 8;


    public static function getModelLabel(): string
    {
        return __('Booking');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Bookings');
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
            ->emptyStateHeading(__('No Bookings Found'))
            ->emptyStateDescription(__('No bookings found'))
            ->emptyStateIcon('icon-online_order')
            ->striped()
            ->heading(__('Bookings'))
            ->description(__('Here you can view all bookings'))
            ->modifyQueryUsing(function (Builder $query) {
                return $query->latest('created_at');
            })
            ->columns([
                TextColumn::make("booking_number")
                    ->badge()
                    ->label(__('Booking Number')),


                TextColumn::make('customer_name')
                    ->default('NA')
                    ->label(__('user name')),


                TextColumn::make('customer_email')
                    ->default('NA')
                    ->label(__('email')),

                TextColumn::make('room_number')
                    ->default('NA')
                    ->label(__('Room Number')),
                TextColumn::make('room_type')
                    ->default('NA')
                    ->badge()
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
                    })
                    ->label(__('Room Type')),

                TextColumn::make('total_price')
                    ->money('EGP')
                    ->default(0)
                    ->label(__('Total Price')),
                TextColumn::make('count_reservation')
                    ->formatStateUsing(fn($state) => $state > 1 ? $state . ' ' . __('Nights') : $state . ' ' . __('Night'))
                    ->default(0)
                    ->label(__('Count Reservation')),
                TextColumn::make('start_date')
                    ->label(__('Start Date')),

                TextColumn::make('end_date')
                    ->label(__('End Date')),






                TextColumn::make('status')
                    ->label(__('Status'))
                    ->color(fn(Booking $order) => match ($order->status) {
                        'pending' => 'gray',
                        'confirmed' => 'primary',
                        'canceled' => 'danger',
                    })
                    ->icon(fn(Booking $order) => match ($order->status) {
                        'pending' => 'icon-pending',
                        'confirmed' => 'icon-checked',
                        'canceled' => 'icon-multiply',
                    })
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'pending' => __('Pending'),
                        'confirmed' => __('Confirmed'),
                        'canceled' => __('Canceled'),
                    })
                    ->badge(),





            ])
            ->filters([
                SelectFilter::make('user_id')
                    ->label(__('User'))
                    ->relationship('user', 'name'),
                SelectFilter::make('room_id')
                    ->label(__('Room'))
                    ->relationship('room', 'number'),
                // SelectFilter::make('status')
                //     ->label(__('Status'))
                //     ->options([
                //         'pending' => __('Pending'),
                //         'confirmed' => __('Confirmed'),
                //         'canceled' => __('Canceled'),
                //     ])


            ])
            ->actions([
                Tables\Actions\ActionGroup::make([

                    Action::make('change_status')
                        ->label(__('Change Status'))
                        ->form([
                            Select::make('status')
                                ->options([
                                    'pending' => __('Pending'),
                                    'confirmed' => __('Confirmed'),
                                    'canceled' => __('Canceled'),
                                ])
                                ->label(__('Status'))
                                ->required()
                                ->default(fn(Booking $record) => $record->status),
                        ])
                        ->action(function (Booking $record, array $data) {
                            $newStatus = $data['status'];
                            $currentStatus = $record->status;

                            // تحقق من الانتقال مسموح به
                            if (!$record->canChangeStatusTo($newStatus)) {
                                $allowed = $record->getAllowedNextStatuses();
                                Notification::make()
                                    ->title(__("لا يمكن تغيير الحالة من $currentStatus إلى $newStatus. الحالات المسموحة: $allowed"))
                                    ->danger()
                                    ->send();

                                return;
                            }

                            // تحديث الحالة
                            $record->update(['status' => $newStatus]);

                            Notification::make()
                                ->title(__('تم تغيير حالة الطلب بنجاح'))
                                ->success()
                                ->send();
                        })
                        ->icon('icon-online_order')





                ]),
            ]);

    }





    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            // 'view' => Pages\ViewOrder::route('/{record}'),
        ];
    }
}

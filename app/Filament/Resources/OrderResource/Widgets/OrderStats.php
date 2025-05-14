<?php

namespace App\Filament\Resources\OrderResource\Widgets;

use App\Models\Order;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class OrderStats extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Pending Orders', Order::query()->where('status', 'pending')->count())
                ->label(__('Pending Orders'))->icon('heroicon-o-clock'),

            Stat::make('Accepted Orders', Order::query()->where('status', 'accepted')->count())
                ->label(__('Accepted Orders'))->icon('heroicon-o-check-circle'),


            Stat::make('Completed Orders', Order::query()->where('status', 'completed')->count())
                ->label(__('Completed Orders'))->icon('heroicon-o-truck'),

            Stat::make('Canceled Orders', Order::query()->where('status', 'canceled')->count())
                ->label(__('Canceled Orders'))->icon('heroicon-o-x-circle'),

            // Stat::make('Average Price', Number::currency(Order::query()->avg('grand_total'), 'USD'))
            //     ->label(__('Average Price'))->icon('heroicon-o-currency-dollar'),

        ];
    }
}

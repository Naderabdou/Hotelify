<?php

namespace App\Filament\Resources\OrderResource\Pages;

use Filament\Actions;
use Filament\Support\Enums\IconPosition;
use App\Filament\Resources\OrderResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use App\Filament\Resources\OrderResource\Widgets\OrderStats;

class ListOrders extends ListRecords
{
    protected static string $resource = OrderResource::class;



    // protected function getHeaderWidgets(): array
    // {
    //     return [
    //         OrderStats::make(),
    //     ];
    // }

    public function getTabs(): array
    {
        return [
            null => Tab::make(__('All'))
                ->icon('icon-all')
                ->iconPosition(IconPosition::Before),

            'pending' => Tab::make(__('Pending'))
                ->icon('icon-pending')
                ->iconPosition(IconPosition::Before)
                ->query(fn($query) => $query->where('status', 'pending')),

            'confirmed' => Tab::make(__('Confirmed'))
                ->icon('icon-checked')
                ->iconPosition(IconPosition::Before)
                ->query(fn($query) => $query->where('status', 'confirmed')),




            'canceled' => Tab::make(__('Canceled'))
                ->icon('icon-multiply')
                ->iconPosition(IconPosition::Before)
                ->query(fn($query) => $query->where('status', 'canceled')),
        ];
    }
}

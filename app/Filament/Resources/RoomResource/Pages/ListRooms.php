<?php

namespace App\Filament\Resources\RoomResource\Pages;

use Filament\Actions;
use Filament\Support\Enums\MaxWidth;
use App\Filament\Resources\RoomResource;
use Filament\Resources\Pages\ListRecords;

class ListRooms extends ListRecords
{
    protected static string $resource = RoomResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->slideOver()->modalWidth(MaxWidth::Large)->successNotificationTitle(__('Room created successfully')),
        ];
    }
}

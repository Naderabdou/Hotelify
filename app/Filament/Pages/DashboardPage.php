<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Pages\Dashboard;
use App\Filament\Widgets\StatsOverview;

class DashboardPage extends Dashboard
{
    protected static ?string $navigationIcon = 'icon-home';

    protected static string $view = 'filament.pages.dashboard';
    protected function getFooterWidgets(): array
    {
        return [
            // StatsOverview::class, // Add your custom widget here
        ];
    }

}

<?php

namespace App\Filament\Pages;

use Filament\Forms;
use Filament\Forms\Form;
use App\Rules\EamilDomains;

use Filament\Pages\SettingsPage;
use App\Settings\GeneralSettings;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Cheesegrits\FilamentGoogleMaps\Fields\Map;

class Settings extends SettingsPage
{
    public static function getNavigationGroup(): ?string
    {
        return __('Settings');
    }
    public static function getNavigationLabel(): string
    {
        return __('Settings');
    }
    public function getTitle(): string
    {
        return __('Settings');
    }
    // public static function canAccess(): bool
    // {
    //     return auth()->user()->type === 'Admin';
    // }

    protected static ?string $navigationIcon = 'icon-settings';
    protected static ?int $navigationSort = 7;
    protected static string $settings = GeneralSettings::class;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Settings')
                    ->tabs([
                        Tabs\Tab::make(__('General'))
                            ->icon('heroicon-o-cog-6-tooth')
                            ->badge(4)
                            ->schema([
                                TextInput::make('site_name_ar')
                                    ->label(__('Site Name (Arabic)'))
                                    ->autofocus()
                                    ->minLength(3)
                                    ->maxLength(255)
                                    ->required(),
                                TextInput::make('site_name_en')
                                    ->label(__('Site Name (English)'))
                                    ->autofocus()
                                    ->minLength(3)
                                    ->maxLength(255)
                                    ->required(),




                                FileUpload::make('logo')
                                    ->label(__('Logo'))
                                    ->image()
                                    ->disk('public')
                                    ->directory('settings')
                                    ->columnSpanFull()
                                    ->reorderable()
                                    ->required(),

                                FileUpload::make('favicon')
                                    ->label(__('Favicon'))
                                    ->image()
                                    ->disk('public')
                                    ->directory('settings')
                                    ->columnSpanFull()

                                    ->reorderable()
                                    ->required(),


                            ])->columns(2),
                        Tabs\Tab::make(__('Contact Details'))
                            ->icon('heroicon-o-at-symbol')
                            ->badge(11)
                            ->schema([
                                TextInput::make('email')
                                    ->label(__('Email'))
                                    ->autofocus()
                                    ->email()
                                    ->minLength(3)
                                    ->required(),
                                TextInput::make('phone')
                                    ->label(__('Phone'))
                                    ->autofocus()
                                    ->maxLength(15)
                                    ->required(),
                                TextInput::make('whatsapp')
                                    ->label(__('whatsapp'))
                                    ->autofocus()
                                    ->maxLength(20)
                                    ->required(),





                                TextInput::make('facebook')
                                    ->label(__('facebook'))
                                    ->autofocus()
                                    ->url()

                                    ->required(),


                                TextInput::make('instagram')
                                    ->label(__('instagram'))
                                    ->autofocus()
                                    ->url()
                                    ->columnSpanFull()

                                    ->required(),

                                TextInput::make('address')
                                    ->label(__('Address'))
                                    ->autofocus()
                                    ->placeholder(__('Enter your address'))
                                    ->required()
                                    ->columnSpanFull()
                                    ->maxLength(255),
                                Map::make('location')
                                    ->hiddenLabel()
                                    ->columnSpanFull()

                                    ->mapControls([
                                        'mapTypeControl'    => true,
                                        'scaleControl'      => true,
                                        'rotateControl'     => true,
                                        'fullscreenControl' => true,
                                        'searchBoxControl'  => false, // creates geocomplete field inside map
                                        'zoomControl'       => false,
                                    ])
                                    ->height(fn() => '400px') // map height (width is controlled by Filament options)
                                    ->defaultZoom(5) // default zoom level when opening form
                                    ->autocomplete('address') // field on form to use as Places geocompletion field
                                    ->draggable(false) // allow dragging to move marker

                                    ->clickable(false) // allow clicking to move marker

                            ])->columns(2),










                        // Tabs\Tab::make(__('privacy and return delivery policy'))
                        //     ->icon('heroicon-o-truck')
                        //     ->badge(4)
                        //     ->schema([])->columns(2),



                    ]),
            ])->columns(1);
    }
}

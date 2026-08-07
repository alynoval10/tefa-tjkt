<?php

namespace App\Filament\Pages;

use BackedEnum;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;

class Settings extends Page
{
    protected static ?string $navigationLabel = 'Pengaturan';

    protected static string|\UnitEnum|null $navigationGroup = 'Sistem';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    protected static ?int $navigationSort = 99;

    protected static ?string $title = 'Pengaturan';

    protected static ?string $slug = 'settings';

    protected string $view = 'filament.pages.settings';
}
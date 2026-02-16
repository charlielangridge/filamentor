<?php

namespace Geosem42\Filamentor\Tests;

use Filament\Panel;
use Filament\PanelProvider;
use Geosem42\Filamentor\FilamentorPlugin;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->plugins([
                FilamentorPlugin::make(),
            ]);
    }
}

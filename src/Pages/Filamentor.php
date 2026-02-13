<?php

namespace Geosem42\Filamentor\Pages;

use Filament\Pages\Page;

class Filamentor extends Page
{
    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationLabel = 'Page Builder';
    protected static ?string $title = 'Page Builder';
    protected string $view = 'filamentor::pages.filamentor';
}

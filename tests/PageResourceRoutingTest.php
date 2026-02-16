<?php

use Filament\Panel;
use Geosem42\Filamentor\Resources\PageResource;
use Illuminate\Support\Facades\Route;

it('uses a non-colliding default resource slug', function (): void {
    config()->set('filamentor.resource_slug', 'filamentor-pages');

    expect(PageResource::getSlug())->toBe('filamentor-pages');
});

it('registers routes using the configured resource slug', function (): void {
    config()->set('filamentor.resource_slug', 'filamentor-pages');

    $panel = Panel::make()
        ->id('admin')
        ->path('admin');

    Route::name($panel->generateRouteName(''))
        ->prefix($panel->getPath())
        ->group(function () use ($panel): void {
            PageResource::registerRoutes($panel);
        });

    $filamentorRoutes = collect(Route::getRoutes())
        ->map(fn ($route) => $route->uri())
        ->filter(fn (string $uri): bool => str_contains($uri, 'filamentor-pages'));

    expect($filamentorRoutes)->not->toBeEmpty();
});

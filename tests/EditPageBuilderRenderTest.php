<?php

use Geosem42\Filamentor\Models\Page;
use Geosem42\Filamentor\Resources\PageResource\Pages\EditPage;

it('uses normalized layout json state for the builder view', function (): void {
    $layout = [
        [
            'id' => 1,
            'order' => 0,
            'columns' => [],
        ],
    ];

    $page = Page::query()->create([
        'title' => 'Builder Test',
        'slug' => 'builder-test',
        'description' => null,
        'layout' => $layout,
        'is_published' => false,
    ]);

    $component = app(EditPage::class);

    $reflection = new \ReflectionClass($component);
    $recordProperty = $reflection->getProperty('record');
    $recordProperty->setAccessible(true);
    $recordProperty->setValue($component, $page);

    expect($component->getLayoutStateJson())->toBe(json_encode($layout));
});

it('keeps a single filamentor alpine root in the builder view', function (): void {
    $builderView = file_get_contents(__DIR__ . '/../resources/views/pages/builder.blade.php');

    expect($builderView)->not->toBeFalse();
    expect(substr_count($builderView, 'x-data="filamentor"'))->toBe(1);
    expect($builderView)->not->toContain('value="{{ $this->record->layout }}"');
});

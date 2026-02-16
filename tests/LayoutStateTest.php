<?php

use Geosem42\Filamentor\Support\LayoutState;

it('normalizes array layout state to json string', function (): void {
    $layout = [['id' => 1, 'columns' => []]];

    expect(LayoutState::toJsonString($layout))
        ->toBe(json_encode($layout));
});

it('normalizes null and empty layout state to empty json array string', function (): void {
    expect(LayoutState::toJsonString(null))->toBe('[]');
    expect(LayoutState::toJsonString(''))->toBe('[]');
    expect(LayoutState::toJsonString('   '))->toBe('[]');
    expect(LayoutState::toJsonString('null'))->toBe('[]');
});

it('keeps valid json string layout state unchanged', function (): void {
    $layout = '[{"id":123,"columns":[]}]';

    expect(LayoutState::toJsonString($layout))->toBe($layout);
});

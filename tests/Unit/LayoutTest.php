<?php

declare(strict_types=1);

use Revoltify\Support\Forms\Components\Field;
use Revoltify\Support\Forms\Components\Grid;
use Revoltify\Support\Forms\Components\Section;
use Revoltify\Support\Forms\Components\Tab;
use Revoltify\Support\Forms\Components\Tabs;

it('builds a grid with columns and schema', function () {
    $grid = Grid::make('layout', 3)->schema([
        Field::make('first')->text(),
    ]);

    $array = $grid->toArray();

    expect($grid->getType())->toBe('grid')
        ->and($array['columns'])->toBe(3)
        ->and($array['schema'])->toHaveCount(1);
});

it('builds a collapsible section', function () {
    $section = Section::make('profile')
        ->label('Profile')
        ->collapsible()
        ->collapsed()
        ->schema([Field::make('name')->text()]);

    $array = $section->toArray();

    expect($section->getType())->toBe('section')
        ->and($section->getLabel())->toBe('Profile')
        ->and($array['collapsible'])->toBeTrue()
        ->and($array['collapsed'])->toBeTrue()
        ->and($array['schema'])->toHaveCount(1);
});

it('builds tabs containing tab components', function () {
    $tabs = Tabs::make('settings')->tabs([
        Tab::make('general')->label('General')->schema([
            Field::make('site_name')->text(),
        ]),
        Tab::make('security')->label('Security')->icon('shield'),
    ]);

    $array = $tabs->toArray();

    expect($tabs->getType())->toBe('tabs')
        ->and($array['tabs'])->toHaveCount(2)
        ->and($array['tabs'][0]->getType())->toBe('tab')
        ->and($array['tabs'][0]->getLabel())->toBe('General')
        ->and($array['tabs'][1]->toArray()['icon'])->toBe('shield');
});

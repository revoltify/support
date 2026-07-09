<?php

declare(strict_types=1);

use Revoltify\Support\Forms\Components\Field;
use Revoltify\Support\Forms\Form;

it('keys fields by their component key', function () {
    $form = Form::make([
        Field::make('name')->text(),
        Field::make('email')->email(),
    ]);

    expect($form->getFieldKeys())->toBe(['name', 'email'])
        ->and($form->hasField('name'))->toBeTrue()
        ->and($form->getField('email'))->not->toBeNull();
});

it('ignores values that are not form components', function () {
    $form = Form::make([
        Field::make('name')->text(),
        'not-a-component',
        42,
    ]);

    expect($form->getFieldKeys())->toBe(['name']);
});

it('reports whether it has fields', function () {
    expect(Form::make()->hasFields())->toBeFalse()
        ->and(Form::make([Field::make('name')->text()])->hasFields())->toBeTrue();
});

it('returns null for an unknown field', function () {
    expect(Form::make()->getField('missing'))->toBeNull()
        ->and(Form::make()->hasField('missing'))->toBeFalse();
});

it('serializes each field to an array keyed by field key', function () {
    $array = Form::make([
        Field::make('name')->text(),
        Field::make('email')->email(),
    ])->toArray();

    expect($array)->toHaveKeys(['name', 'email'])
        ->and($array['name']['type'])->toBe('text')
        ->and($array['email']['type'])->toBe('email');
});

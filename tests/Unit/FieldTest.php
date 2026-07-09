<?php

declare(strict_types=1);

use Revoltify\Support\Forms\Components\Field;

it('derives a humanized label from the key', function () {
    $field = Field::make('created_at');

    expect($field->getKey())->toBe('created_at')
        ->and($field->getLabel())->toBe('Created at');
});

it('defaults to the text type', function () {
    expect(Field::make('name')->getType())->toBe('text');
});

it('sets the type and value for each field method', function () {
    expect(Field::make('a')->email('me@example.com')->getType())->toBe('email')
        ->and(Field::make('b')->email('me@example.com')->getValue())->toBe('me@example.com')
        ->and(Field::make('c')->password()->getType())->toBe('password')
        ->and(Field::make('d')->checkbox(true)->getValue())->toBeTrue()
        ->and(Field::make('e')->textarea('note')->getType())->toBe('textarea');
});

it('stores select options and value', function () {
    $field = Field::make('role')->select(['admin' => 'Admin', 'member' => 'Member'], 'admin');

    expect($field->getType())->toBe('options')
        ->and($field->getOptions())->toBe(['admin' => 'Admin', 'member' => 'Member'])
        ->and($field->getValue())->toBe('admin');
});

it('builds a toggle from select options', function () {
    $field = Field::make('status')->toggle('enable');

    expect($field->getOptions())->toBe(['enable' => 'Enable', 'disable' => 'Disable'])
        ->and($field->getDefault())->toBe('enable');
});

it('normalizes a single rule into a list', function () {
    $field = Field::make('email')->rules('required');

    expect($field->toArray()['rules'])->toBe(['required']);
});

it('keeps an array of rules as-is', function () {
    $field = Field::make('email')->rules(['required', 'email']);

    expect($field->toArray()['rules'])->toBe(['required', 'email']);
});

it('falls back to value when no default is set', function () {
    expect(Field::make('name')->value('john')->getDefault())->toBe('john');
});

it('is chainable and returns the same instance', function () {
    $field = Field::make('name');

    expect($field->text()->required()->disabled())->toBe($field);
});

it('serializes every configured property', function () {
    $array = Field::make('email')
        ->email('me@example.com')
        ->required()
        ->placeholder('Your email')
        ->rules(['required', 'email'])
        ->toArray();

    expect($array)
        ->toHaveKeys(['type', 'label', 'value', 'required', 'placeholder', 'rules'])
        ->and($array['type'])->toBe('email')
        ->and($array['required'])->toBeTrue()
        ->and($array['placeholder'])->toBe('Your email');
});

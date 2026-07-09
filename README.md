# Revoltify Support

Core support utilities for Revoltify packages. Ships a fluent, framework-agnostic form schema builder that serializes to plain arrays — ready to hand off to a frontend renderer or API.

## Requirements

- PHP `^8.2`

## Installation

```bash
composer require revoltify/support
```

## Usage

Build a form from a list of components and convert it to an array:

```php
use Revoltify\Support\Forms\Form;
use Revoltify\Support\Forms\Components\Field;

$form = Form::make([
    Field::make('name')->text()->required(),
    Field::make('email')->email()->required(),
    Field::make('role')->select([
        'admin' => 'Admin',
        'member' => 'Member',
    ])->searchable(),
]);

$schema = $form->toArray();
```

`Form::make()` accepts any array; only values implementing `FormComponent` are kept, keyed by their `getKey()`.

### Fields

`Field::make($key)` derives a default label from the key (`created_at` → `Created at`). Chain a type method, then modifiers:

```php
Field::make('bio')->textarea(rows: 5)->helperText('Short description');
Field::make('password')->password()->revealable()->required();
Field::make('tags')->tags(['php', 'laravel']);
Field::make('avatar')->file()->image()->acceptedFileTypes(['image/png', 'image/jpeg']);
Field::make('config')->codeEditor()->language('json');
```

**Types:** `text`, `password`, `email`, `number`, `textarea`, `markdown`, `select`, `radio`, `checkbox`, `file`, `color`, `tags`, `codeEditor`, `toggle`.

**Common modifiers:** `label`, `value`, `default`, `placeholder`, `helperText`, `tooltip`, `hint`, `hintIcon`, `hintColor`, `hintActionUrl`, `required`, `disabled`, `readOnly`, `live`, `columnSpanFull`, `rules`, `visible`, `visibleWhen`, `dependent`, `options`, `multiple`, `searchable`, `preload`, `maxLength`, `minLength`, `prefix`, `suffix`, `suffixCopy`, `min`, `max`, `step`, `rows`, `maxSize`, `image`.

### Layout components

`Grid`, `Section`, `Tab`, and `Tabs` group fields. Each implements `FormComponent`, so they slot into a form or nest inside one another:

```php
use Revoltify\Support\Forms\Components\{Section, Grid, Tabs, Tab};

Form::make([
    Section::make('profile')
        ->label('Profile')
        ->collapsible()
        ->schema([
            Grid::make('name_grid', columns: 2)->schema([
                Field::make('first_name')->text(),
                Field::make('last_name')->text(),
            ]),
        ]),

    Tabs::make('settings')->tabs([
        Tab::make('general')->label('General')->schema([
            Field::make('site_name')->text(),
        ]),
        Tab::make('security')->label('Security')->icon('shield')->schema([
            Field::make('two_factor')->toggle(),
        ]),
    ]),
]);
```

### Conditional visibility

```php
Field::make('company')->text()->visibleWhen('account_type', 'business');
Field::make('vat')->text()->visible(fn ($state) => $state['country'] === 'DE');
```

## Testing

```bash
composer stan   # PHPStan (level max)
composer pint   # Laravel Pint
composer rector # Rector
```

## License

MIT — see [LICENSE.md](LICENSE.md).

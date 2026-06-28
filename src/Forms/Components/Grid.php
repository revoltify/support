<?php

declare(strict_types=1);

namespace Revoltify\Support\Forms\Components;

use Revoltify\Support\Forms\Contracts\FormComponent;

class Grid implements FormComponent
{
    private string $key;

    private int $columns;

    /** @var list<FormComponent> */
    private array $schema = [];

    public static function make(string $key, int $columns = 2): self
    {
        $instance = new self;
        $instance->key = $key;
        $instance->columns = $columns;

        return $instance;
    }

    public function columns(int $columns): self
    {
        $this->columns = $columns;

        return $this;
    }

    /**
     * @param  list<FormComponent>  $schema
     */
    public function schema(array $schema): self
    {
        $this->schema = $schema;

        return $this;
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function getLabel(): ?string
    {
        return null;
    }

    public function getType(): string
    {
        return 'grid';
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'type' => 'grid',
            'key' => $this->key,
            'columns' => $this->columns,
            'schema' => $this->schema,
        ];
    }
}

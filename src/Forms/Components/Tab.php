<?php

declare(strict_types=1);

namespace Revoltify\Support\Forms\Components;

use Revoltify\Support\Forms\Contracts\FormComponent;

class Tab implements FormComponent
{
    private string $key;

    private ?string $label = null;

    private ?string $icon = null;

    private ?string $badge = null;

    private array $schema = [];

    public static function make(string $key): self
    {
        $instance = new self;
        $instance->key = $key;

        return $instance;
    }

    public function label(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function icon(string $icon): self
    {
        $this->icon = $icon;

        return $this;
    }

    public function badge(string $badge): self
    {
        $this->badge = $badge;

        return $this;
    }

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
        return $this->label;
    }

    public function getType(): string
    {
        return 'tab';
    }

    public function toArray(): array
    {
        return [
            'type' => 'tab',
            'key' => $this->key,
            'label' => $this->label,
            'icon' => $this->icon,
            'badge' => $this->badge,
            'schema' => $this->schema,
        ];
    }
}

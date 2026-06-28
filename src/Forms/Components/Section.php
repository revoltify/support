<?php

declare(strict_types=1);

namespace Revoltify\Support\Forms\Components;

use Revoltify\Support\Forms\Contracts\FormComponent;

class Section implements FormComponent
{
    private string $key;

    private ?string $label = null;

    private ?string $description = null;

    private ?string $icon = null;

    /** @var list<FormComponent> */
    private array $schema = [];

    private bool $collapsible = false;

    private bool $collapsed = false;

    private bool $compact = false;

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

    public function description(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function icon(string $icon): self
    {
        $this->icon = $icon;

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

    public function collapsible(bool $collapsible = true): self
    {
        $this->collapsible = $collapsible;

        return $this;
    }

    public function collapsed(bool $collapsed = true): self
    {
        $this->collapsed = $collapsed;

        return $this;
    }

    public function compact(bool $compact = true): self
    {
        $this->compact = $compact;

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
        return 'section';
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'type' => 'section',
            'key' => $this->key,
            'label' => $this->label,
            'description' => $this->description,
            'icon' => $this->icon,
            'schema' => $this->schema,
            'collapsible' => $this->collapsible,
            'collapsed' => $this->collapsed,
            'compact' => $this->compact,
        ];
    }
}

<?php

declare(strict_types=1);

namespace Revoltify\Support\Forms\Components;

use Revoltify\Support\Forms\Contracts\FormComponent;

class Tabs implements FormComponent
{
    private string $key;

    private ?string $label = null;

    private array $tabs = [];

    private bool $columnSpanFull = false;

    private bool $persistTabInQueryString = false;

    private ?bool $contained = null;

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

    public function tabs(array $tabs): self
    {
        $this->tabs = $tabs;

        return $this;
    }

    public function columnSpanFull(bool $columnSpanFull = true): self
    {
        $this->columnSpanFull = $columnSpanFull;

        return $this;
    }

    public function persistTabInQueryString(bool $persist = true): self
    {
        $this->persistTabInQueryString = $persist;

        return $this;
    }

    public function contained(bool $contained = true): self
    {
        $this->contained = $contained;

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
        return 'tabs';
    }

    public function toArray(): array
    {
        return [
            'type' => 'tabs',
            'key' => $this->key,
            'label' => $this->label,
            'tabs' => $this->tabs,
            'columnSpanFull' => $this->columnSpanFull,
            'persistTabInQueryString' => $this->persistTabInQueryString,
            'contained' => $this->contained,
        ];
    }
}

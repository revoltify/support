<?php

declare(strict_types=1);

namespace Revoltify\Support\Forms;

use Revoltify\Support\Forms\Contracts\FormComponent;

readonly class Form
{
    /**
     * @var array<string, FormComponent>
     */
    private array $fields;

    /**
     * @param  list<mixed>  $fields
     */
    public function __construct(array $fields = [])
    {
        $validFields = [];
        foreach ($fields as $field) {
            if ($field instanceof FormComponent) {
                $validFields[$field->getKey()] = $field;
            }
        }
        $this->fields = $validFields;
    }

    /**
     * @param  list<mixed>  $fields
     */
    public static function make(array $fields = []): self
    {
        return new self($fields);
    }

    /**
     * Get all components (fields and containers)
     *
     * @return array<string, FormComponent>
     */
    public function getFields(): array
    {
        return $this->fields;
    }

    /**
     * Check if the form has any components
     */
    public function hasFields(): bool
    {
        return $this->fields !== [];
    }

    /**
     * Get a specific component by key
     */
    public function getField(string $key): ?FormComponent
    {
        return $this->fields[$key] ?? null;
    }

    /**
     * Check if a specific component exists
     */
    public function hasField(string $key): bool
    {
        return isset($this->fields[$key]);
    }

    /**
     * Get component keys
     *
     * @return array<int, string>
     */
    public function getFieldKeys(): array
    {
        return array_keys($this->fields);
    }

    /**
     * Convert form to array
     *
     * @return array<string, array<string, mixed>>
     */
    public function toArray(): array
    {
        $forms = [];
        foreach ($this->fields as $key => $field) {
            $forms[$key] = $field->toArray();
        }

        return $forms;
    }
}

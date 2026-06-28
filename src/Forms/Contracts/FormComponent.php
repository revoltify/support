<?php

declare(strict_types=1);

namespace Revoltify\Support\Forms\Contracts;

interface FormComponent
{
    /**
     * Get the component key
     */
    public function getKey(): string;

    /**
     * Get the component type
     */
    public function getType(): string;

    /**
     * Get the component label
     */
    public function getLabel(): ?string;

    /**
     * Convert component to array
     */
    public function toArray(): array;
}

<?php

declare(strict_types=1);

namespace Revoltify\Support\Forms\Contracts;

interface FormComponent
{
    public function getKey(): string;

    public function getType(): string;

    public function getLabel(): ?string;

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array;
}

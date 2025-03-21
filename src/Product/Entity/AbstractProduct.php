<?php

declare(strict_types=1);

namespace AcmeWidgetCo\Product\Entity;

abstract class AbstractProduct
{
    public function __construct(protected string $name)
    {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }
}

<?php

declare(strict_types=1);

namespace AcmeWidgetCo;

interface ModuleInterface
{
    /**
     * Return dependency definitions for this module.
     *
     * @return array<string, mixed>
     */
    public function getDefinitions(): array;
}

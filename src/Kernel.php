<?php

declare(strict_types=1);

namespace AcmeWidgetCo;

use DI\ContainerBuilder;
use Psr\Container\ContainerInterface;

class Kernel
{
    /**
     * @var array<ModuleInterface>
     */
    protected array $modules;

    public function __construct()
    {
        $this->modules = $this->discoverModules();
    }

    /**
     * Automatically discover modules.
     *
     * Assumes that modules are located in subdirectories of src/ and that each module
     * has a file named "Module.php" implementing ModuleInterface.
     *
     * @return array<ModuleInterface>
     */
    protected function discoverModules(): array
    {
        // Ensure we always have an array, even if glob returns false.
        $moduleFiles = glob(__DIR__ . '/*/Module.php') ?: [];
        $modules = [];
        foreach ($moduleFiles as $filename) {
            require_once $filename;
            $moduleName = basename(dirname($filename));
            $className = "AcmeWidgetCo\\{$moduleName}\\Module";
            if (class_exists($className)) {
                $module = new $className();
                if ($module instanceof ModuleInterface) {
                    $modules[] = $module;
                }
            }
        }
        return $modules;
    }

    /**
     * Build and return the dependency injection container.
     *
     * @return ContainerInterface
     */
    public function getContainer(): ContainerInterface
    {
        $containerBuilder = new ContainerBuilder();
        $definitions = [];
        foreach ($this->modules as $module) {
            $definitions = array_merge($definitions, $module->getDefinitions());
        }
        $containerBuilder->addDefinitions($definitions);
        return $containerBuilder->build();
    }
}

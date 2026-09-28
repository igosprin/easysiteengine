<?php

namespace App\Models;

/**
 * Lazy access to models from commands/services: $this->model('User') creates
 * App\Models\UserModel on first use and returns the same instance afterwards.
 * The autoloader only loads the model file at that point — unused ones never load.
 * Requires $this->dbRepository (available on Command and Controller), connection alias 'first'.
 */
trait UsesModels
{
    private array $modelInstances = [];

    protected function model(string $name): BaseModel
    {
        if (!isset($this->modelInstances[$name])) {
            $class = __NAMESPACE__ . '\\' . $name . 'Model';
            $this->modelInstances[$name] = new $class($this->dbRepository->getRepository('first'));
        }

        return $this->modelInstances[$name];
    }
}

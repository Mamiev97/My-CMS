<?php

declare(strict_types=1);

namespace App\DependencyContainer;

use Closure;

class DependencyContainer
{
    private array $dependencies = [];

    /**
     * @param string $key
     * @param Closure $value
     * @return void
     */
    public function set(string $key, Closure $value): void
    {
        $this->dependencies[$key] = $value;
    }

    /**
     * @param string $name
     * @param Closure $callback
     * @return void
     */
    public function setWithDependency(string $name, Closure $callback): void
    {
        $this->dependencies[$name] = $callback($this);
    }

    /**
     * @param string $key
     * @return mixed|null
     */
    public function get(string $key): mixed
    {
        if (isset($this->dependencies[$key])) {
            if ($this->dependencies[$key] instanceof Closure) {
                return $this->dependencies[$key]();
            } else {
                return $this->dependencies[$key];
            }
        }
        return null;
    }
}

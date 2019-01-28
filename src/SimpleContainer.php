<?php

namespace Morphable;

use \Morphable\SimpleContainer\Exception\InstanceAlreadyExists;
use \Morphable\SimpleContainer\Exception\InstanceNotFound;

class SimpleContainer
{
    /**
     * @var bool
     */
    protected $isCaseSensitive;

    /**
     * @var array
     */
    protected $instances;

    /**
     * @param array
     * @param bool
     * @return self
     */
    public function __construct(array $instances = [], bool $isCaseSensitive = true)
    {
        $this->instances = $instances;
        $this->isCaseSensitive = $isCaseSensitive;
    }

    /**
     * @param string
     * @return mixed
     */
    public function get(string $name)
    {
        if (!$this->isCaseSensitive) {
            $name = strtolower($name);
        }

        if (!isset($this->instances[$name])) {
            throw new InstanceNotFound("Instance {$name} does not exists");
        }

        return $this->instances[$name];
    }

    /**
     * @param string
     * @return bool
     */
    public function exists(string $name)
    {
        if (!$this->isCaseSensitive) {
            $name = strtolower($name);
        }

        return (bool) isset($this->instances[$name]);
    }

    /**
     * @param string
     * @param mixed
     * @return self
     */
    public function add(string $name, $instance)
    {
        if (!$this->isCaseSensitive) {
            $name = strtolower($name);
        }

        if (isset($this->instances[$name])) {
            throw new InstanceAlreadyExists("Instance {$name} already exists, please use update() instead");
        }

        $this->instances[$name] = $instance;

        return $this;
    }

    /**
     * @param string
     * @param mixed
     * @return self
     */
    public function update(string $name, $instance)
    {
        if (!$this->isCaseSensitive) {
            $name = strtolower($name);
        }

        if (!isset($this->instances[$name])) {
            throw new InstanceNotFound("Instance {$name} does not exists");
        }

        $this->instances[$name] = $instance;

        return $this;
    }

    /**
     * @param string
     * @return self
     */
    public function delete(string $name)
    {
        if (!$this->isCaseSensitive) {
            $name = strtolower($name);
        }

        if (!isset($this->instances[$name])) {
            throw new InstanceNotFound("Instance {$name} does not exists");
        }

        unset($this->instances[$name]);

        return $this;
    }
}

<?php

namespace Morphable\SimpleContainer;

use \Morphable\SimpleContainer\Exception\MissingMethod;
use \Morphable\SimpleContainer\Exception\NonExecutableItem;

/**
 * Container ment for keeping events
 */
class ExecutableContainer extends \Morphable\SimpleContainer
{
    /**
     * Method name
     *
     * @var string
     */
    protected $method;

    /**
     * @param string method name
     * @param array instances
     */
    public function __construct(string $method, array $instances = [])
    {
        $this->method = $method;
        parent::__construct($instances);
    }

    /**
     * Execute the classes inside container
     *
     * @param mixed params
     * @return self
     */
    public function execute(...$params)
    {
        foreach ($this->instances as $name => $instance) {
            if (!is_object($instance)) {
                throw new NonExecutableItem("Cannot execute item of type " . gettype($instance));
            }

            if (!method_exists($instance, $this->method)) {
                throw new MissingMethod("Missing method {$this->method} in class " . get_class($instance));
            }

            call_user_func_array([$instance, $this->method], $params);
        }

        return $this;
    }
}

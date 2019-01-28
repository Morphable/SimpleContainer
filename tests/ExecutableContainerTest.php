<?php

use PHPUnit\Framework\TestCase;
use \Morphable\SimpleContainer\ExecutableContainer;

class ExecutableContainerTest extends TestCase
{
    public function testAll()
    {
        $classWithRightMethod = new class {

            public $hasBeenExecute = false;

            public function execute(...$params)
            {
                $this->hasBeenExecute = true;
            }

            public function checkExecute()
            {
                return $this->hasBeenExecute;
            }
        };

        $events = new ExecutableContainer("execute");
        $events->add("classWithRightMethod", $classWithRightMethod);
        $events->execute(1,2,3);

        $this->assertTrue($classWithRightMethod->checkExecute());
        $events->delete("classWithRightMethod");

        $events->add("nonExecutable", "string");

        try {
            $events->execute();
            $this->assertTrue(false);
        } catch (\Morphable\SimpleContainer\Exception\NonExecutableItem $e) {
            $this->assertTrue(true);
        }

        $events->delete("nonExecutable");

        $classWithoutRightMethod = new class {};

        $events->add("classWithoutRightMethod", $classWithoutRightMethod);
        try {
            $events->execute();
            $this->assertTrue(false);
        } catch (\Morphable\SimpleContainer\Exception\MissingMethod $e) {
            $this->assertTrue(true);
        }

        $events->delete("classWithoutRightMethod");
    }
}

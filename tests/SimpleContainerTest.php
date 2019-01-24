<?php

use PHPUnit\Framework\TestCase;

use \Morphable\SimpleContainer;

class SimpleContainerTests extends TestCase
{
    public function testAll()
    {
        $container = new SimpleContainer();
        $container->add('test', 'yes');

        $this->assertTrue($container->exists('test'));

        $container->delete('test');

        $this->assertTrue(!$container->exists('test'));

        $container->add('test', 'yes');

        $this->assertSame($container->get('test'), 'yes');

        $container->update('test', 'no');

        $this->assertSame($container->get('test'), 'no');

        try {
            $container->get('not_a_test');
            $this->assertTrue(false);
        } catch (\Morphable\SimpleContainer\Exception\InstanceNotFound $e) {
            $this->assertTrue(true);
        }

        try {
            $container->add('test', 'must fail');
            $this->assertTrue(false);
        } catch (\Morphable\SimpleContainer\Exception\InstanceAlreadyExists $e) {
            $this->assertTrue(true);
        }
    }
}

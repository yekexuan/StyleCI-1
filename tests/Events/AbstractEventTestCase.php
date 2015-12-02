<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Alt Three Services Limited
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\Tests\StyleCI\Events;

use ReflectionClass;
use StyleCI\StyleCI\Events\EventInterface;
use StyleCI\StyleCI\Providers\EventServiceProvider;
use StyleCI\Tests\StyleCI\AbstractAnemicTestCase;

/**
 * This is the abstract event test case class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
abstract class AbstractEventTestCase extends AbstractAnemicTestCase
{
    protected function getEventInterfaces()
    {
        return [EventInterface::class];
    }

    protected function objectHasRules()
    {
        return false;
    }

    public function testEventImplementsTheCorrectInterfaces()
    {
        $event = $this->getObjectAndParams()['object'];

        foreach ($this->getEventInterfaces() as $interface) {
            $this->assertInstanceOf($interface, $event);
        }
    }

    public function testEventHasRegisteredHandlers()
    {
        $property = (new ReflectionClass(EventServiceProvider::class))->getProperty('listen');
        $property->setAccessible(true);

        $class = get_class($this->getObjectAndParams()['object']);
        $mappings = $property->getValue(new EventServiceProvider($this->app));

        $this->assertTrue(isset($mappings[$class]));
        $this->assertGreaterThan(0, count($mappings[$class]));

        foreach ($mappings[$class] as $handler) {
            $this->assertInstanceOf($handler, $this->app->make($handler));
        }
    }
}

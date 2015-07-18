<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Alt Three Services Limited
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\Tests\StyleCI\Commands;

use Illuminate\Contracts\Bus\Dispatcher;
use ReflectionClass;
use StyleCI\Tests\StyleCI\AbstractTestCase;

/**
 * This is the abstract command test case class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
abstract class AbstractCommandTestCase extends AbstractTestCase
{
    public function testCommandIsFinal()
    {
        $rc = new ReflectionClass($this->getCommandObjectAndParams()['object']);

        $this->assertTrue($rc->isFinal());
    }

    public function testHandlerClassIsCorrect()
    {
        $dispatcher = $this->app->make(Dispatcher::class);

        $this->assertSame($this->getHandlerClass(), $dispatcher->getHandlerClass($this->getCommandObjectAndParams()['object']));
    }

    public function testHandlerCanBeResolved()
    {
        $dispatcher = $this->app->make(Dispatcher::class);

        $this->assertInstanceOf($this->getHandlerClass(), $dispatcher->resolveHandler($this->getCommandObjectAndParams()['object']));
    }

    public function testPropertiesMatchTheConstructor()
    {
        $rc = new ReflectionClass($this->getCommandObjectAndParams()['object']);

        $properties = array_map(function ($property) {
            return $property->getName();
        }, $rc->getProperties());

        $params = array_map(function ($param) {
            return $param->getName();
        }, $rc->getMethod('__construct')->getParameters());

        if ($this->commandHasRules()) {
            $params[] = 'rules';
        }

        $this->assertSame($properties, $params);
    }

    public function testPropertiesAreCorrectlyDefined()
    {
        $rc = new ReflectionClass($this->getCommandObjectAndParams()['object']);

        foreach ($rc->getProperties() as $property) {
            $this->assertTrue($property->isPublic());
            $this->assertFalse($property->isStatic());
        }
    }

    public function testCommandBehavesCorrectly()
    {
        extract($this->getCommandObjectAndParams());

        foreach ($params as $key => $value) {
            $this->assertSame($value, $object->{$key});
        }
    }
}

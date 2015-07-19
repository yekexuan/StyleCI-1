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

use Illuminate\Contracts\Bus\Dispatcher;
use StyleCI\Tests\StyleCI\AbstractAnemicTestCase;

/**
 * This is the abstract event test case class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
abstract class AbstractEventTestCase extends AbstractAnemicTestCase
{
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
}

<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Alt Three Services Limited
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\Tests\StyleCI\Jobs;

use ReflectionClass;
use Illuminate\Queue\SerializesModels;
use StyleCI\Tests\StyleCI\AbstractAnemicTestCase;

/**
 * This is the abstract job test case class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
abstract class AbstractJobTestCase extends AbstractAnemicTestCase
{
    protected function objectHasRules()
    {
        return false;
    }

    public function testJobSerializesModels()
    {
        $rc = new ReflectionClass($this->getObjectAndParams()['object']);

        $this->assertSame([SerializesModels::class], $rc->getTraitNames());
    }
}

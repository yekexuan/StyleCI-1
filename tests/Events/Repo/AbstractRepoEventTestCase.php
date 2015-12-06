<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Alt Three Services Limited
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\Tests\StyleCI\Events\Repo;

use AltThree\TestBench\EventTrait;
use StyleCI\StyleCI\Events\EventInterface;
use StyleCI\StyleCI\Events\Repo\RepoEventInterface;
use StyleCI\Tests\StyleCI\AbstractTestCase;

/**
 * This is the abstract repo event test case class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class AbstractRepoEventTestCase extends AbstractTestCase
{
    use EventTrait;

    protected function getEventInterfaces()
    {
        return [EventInterface::class, RepoEventInterface::class];
    }
}

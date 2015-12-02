<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Alt Three Services Limited
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\Tests\StyleCI\Events\User;

use StyleCI\StyleCI\Events\User\UserEventInterface;
use StyleCI\Tests\StyleCI\Events\AbstractEventTestCase;

/**
 * This is the abstract user event test case class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class AbstractUserEventTestCase extends AbstractEventTestCase
{
    protected function getEventInterfaces()
    {
        return array_merge(parent::getEventInterfaces(), [UserEventInterface::class]);
    }
}

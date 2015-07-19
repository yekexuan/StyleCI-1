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

use Exception;
use StyleCI\StyleCI\Events\User\UserHasSignedUpEvent;
use StyleCI\StyleCI\Models\User;

/**
 * This is the user has signed up event test class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class UserHasSignedUpEventTest extends AbstractUserEventTestCase
{
    protected function getObjectAndParams()
    {
        $params = ['user' => new User()];
        $object = new UserHasSignedUpEvent($params['user']);

        return compact('params', 'object');
    }
}

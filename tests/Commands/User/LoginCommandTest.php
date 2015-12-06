<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Alt Three Services Limited
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\Tests\StyleCI\Commands\User;

use AltThree\TestBench\CommandTrait;
use StyleCI\StyleCI\Commands\User\LoginCommand;
use StyleCI\StyleCI\Handlers\Commands\User\LoginCommandHandler;
use StyleCI\Tests\StyleCI\AbstractTestCase;

/**
 * This is the login command test class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class LoginCommandTest extends AbstractTestCase
{
    use CommandTrait;

    protected function getObjectAndParams()
    {
        $params = ['id' => 12345, 'name' => 'Foo Bar', 'username' => 'foo', 'email' => 'foo@bar.com', 'token' => str_repeat('A', 40)];
        $object = new LoginCommand($params['id'], $params['name'], $params['username'], $params['email'], $params['token']);

        return compact('params', 'object');
    }

    protected function objectHasRules()
    {
        return true;
    }

    protected function getHandlerClass()
    {
        return LoginCommandHandler::class;
    }
}

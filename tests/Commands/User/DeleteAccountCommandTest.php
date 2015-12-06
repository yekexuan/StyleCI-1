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
use StyleCI\StyleCI\Commands\User\DeleteAccountCommand;
use StyleCI\StyleCI\Handlers\Commands\User\DeleteAccountCommandHandler;
use StyleCI\StyleCI\Models\User;
use StyleCI\Tests\StyleCI\AbstractTestCase;

/**
 * This is the delete account command test class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class DeleteAccountCommandTest extends AbstractTestCase
{
    use CommandTrait;

    protected function getObjectAndParams()
    {
        $params = ['user' => new User()];
        $object = new DeleteAccountCommand($params['user']);

        return compact('params', 'object');
    }

    protected function getHandlerClass()
    {
        return DeleteAccountCommandHandler::class;
    }
}

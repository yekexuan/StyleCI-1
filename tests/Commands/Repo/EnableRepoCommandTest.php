<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Alt Three Services Limited
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\Tests\StyleCI\Commands\Repo;

use StyleCI\StyleCI\Commands\Repo\EnableRepoCommand;
use StyleCI\StyleCI\Handlers\Commands\Repo\EnableRepoCommandHandler;
use StyleCI\StyleCI\Models\User;
use StyleCI\Tests\StyleCI\Commands\AbstractCommandTestCase;

/**
 * This is the enable repo command test class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class EnableRepoCommandTest extends AbstractCommandTestCase
{
    protected function getObjectAndParams()
    {
        $params = ['id' => 12345, 'name' => 'Foo/Bar', 'branch' => 'master', 'user' => new User()];
        $object = new EnableRepoCommand($params['id'], $params['name'], $params['branch'], $params['user']);

        return compact('params', 'object');
    }

    protected function objectHasRules()
    {
        return true;
    }

    protected function getHandlerClass()
    {
        return EnableRepoCommandHandler::class;
    }
}

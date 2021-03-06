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

use AltThree\TestBench\CommandTrait;
use StyleCI\StyleCI\Commands\Repo\DisableRepoCommand;
use StyleCI\StyleCI\Handlers\Commands\Repo\DisableRepoCommandHandler;
use StyleCI\StyleCI\Models\Repo;
use StyleCI\Tests\StyleCI\AbstractTestCase;

/**
 * This is the disable repo command test class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class DisableRepoCommandTest extends AbstractTestCase
{
    use CommandTrait;

    protected function getObjectAndParams()
    {
        $params = ['repo' => new Repo()];
        $object = new DisableRepoCommand($params['repo']);

        return compact('params', 'object');
    }

    protected function getHandlerClass()
    {
        return DisableRepoCommandHandler::class;
    }
}

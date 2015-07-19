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

use StyleCI\StyleCI\Events\Repo\RepoWasDisabledEvent;
use StyleCI\StyleCI\Models\Repo;

/**
 * This is the repo was disabled event test class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class RepoWasDisabledEventTest extends AbstractRepoEventTestCase
{
    protected function getObjectAndParams()
    {
        $params = ['repo' => new Repo()];
        $object = new RepoWasDisabledEvent($params['repo']);

        return compact('params', 'object');
    }
}

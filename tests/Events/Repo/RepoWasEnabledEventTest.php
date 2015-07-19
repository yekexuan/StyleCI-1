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

use Exception;
use StyleCI\StyleCI\Events\Repo\RepoWasEnabledEvent;
use StyleCI\StyleCI\Models\Repo;

/**
 * This is the repo was enabled event test class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class RepoWasEnabledEventTest extends AbstractRepoEventTestCase
{
    protected function getObjectAndParams()
    {
        $params = ['repo' => new Repo()];
        $object = new RepoWasEnabledEvent($params['repo']);

        return compact('params', 'object');
    }
}

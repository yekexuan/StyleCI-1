<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Alt Three Services Limited
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\Tests\StyleCI\Events\Repo\GitHub;

use StyleCI\StyleCI\Events\Repo\GitHub\GitHubEventInterface;
use StyleCI\StyleCI\Models\Repo;
use StyleCI\Tests\StyleCI\Events\Repo\AbstractRepoEventTestCase;

/**
 * This is the abstract github event test case class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
abstract class AbstractGitHubEventTestCase extends AbstractRepoEventTestCase
{
    protected function getObjectAndParams()
    {
        $class = $this->getEventClass();
        $params = ['repo' => new Repo(), 'data' => []];
        $object = new $class($params['repo'], $params['data']);

        return compact('params', 'object');
    }

    protected function getEventInterfaces()
    {
        return array_merge(parent::getEventInterfaces(), [GitHubEventInterface::class]);
    }
}

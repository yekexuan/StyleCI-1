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

use StyleCI\StyleCI\Events\Repo\GitHub\GitHubPullRequestEvent;

/**
 * This is the github pull request event test class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class GitHubPullRequestEventTest extends AbstractGitHubEventTestCase
{
    protected function getEventClass()
    {
        return GitHubPullRequestEvent::class;
    }
}

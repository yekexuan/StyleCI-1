<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Alt Three Services Limited
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\StyleCI\Handlers\Events\Repo;

use StyleCI\StyleCI\Events\Repo\RepoEventInterface;

/**
 * This is the analysis visibility handler class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class AnalysisVisibilityHandler
{
    /**
     * Handle the github delete event.
     *
     * @param \StyleCI\StyleCI\Events\Repo\GitHub\GitHubDeleteEvent  $event
     *
     * @return void
     */
    public function handle(GitHubDeleteEvent $event)
    {
        if ($event->data['ref_type'] !== 'branch') {
            return;
        }

        $event->repo->analyses()->visible()->where('branch', $event->data['ref'])->update(['hidden' => 1]);
    }
}

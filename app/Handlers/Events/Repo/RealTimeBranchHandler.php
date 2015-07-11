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

use Pusher;
use StyleCI\StyleCI\Events\Repo\GitHub\GitHubEventInterface;
use StyleCI\StyleCI\Events\Repo\GitHub\GitHubCreateEvent;
use StyleCI\StyleCI\GitHub\Branches;

/**
 * This is the real time branch handler class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class RealTimeBranchHandler
{
    /**
     * The github branches instance.
     *
     * @var \StyleCI\StyleCI\GitHub\Branches
     */
    protected $branches;

    /**
     * The pusher instance.
     *
     * @var \Pusher
     */
    protected $pusher;

    /**
     * Create a new real time branch handler instance.
     *
     * @param \StyleCI\StyleCI\Repositories\UserRepository $userRepository
     * @param \Pusher                                      $pusher
     *
     * @return void
     */
    public function __construct(Branches $branches, Pusher $pusher)
    {
        $this->branches = $branches;
        $this->pusher = $pusher;
    }

    /**
     * Handle the github event.
     *
     * @param \StyleCI\StyleCI\Events\Repo\GitHub\GitHubEventInterface $event
     *
     * @return void
     */
    public function handle(GitHubEventInterface $event)
    {
        if ($event->data['ref_type'] !== 'branch') {
            return;
        }

        if ($event instanceof GitHubCreateEvent) {
            $this->trigger($event->repo, 'BranchWasCreatedEvent');
        } else {
            $this->trigger($event->repo, 'BranchWasDeletedEvent');
        }
    }

    /**
     * Trigger the notification.
     *
     * @param \StyleCI\StyleCI\Models\Repo $repo
     * @param string                       $event
     *
     * @return void
     */
    protected function trigger($repo, $event)
    {
        $branches = $this->branches->get($repo);

        $this->pusher->trigger("repo-{$repo->id}", $event, ['event' => ['branches' => $branches]]);
    }
}

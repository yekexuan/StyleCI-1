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
use StyleCI\StyleCI\Events\Repo\GitHub\GitHubCreateEvent;
use StyleCI\StyleCI\Events\Repo\GitHub\GitHubEventInterface;
use StyleCI\StyleCI\GitHub\Branches;
use StyleCI\StyleCI\Models\Repo;

/**
 * This is the pusher branch handler class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class PusherBranchHandler
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
     * Create a new pusher branch handler instance.
     *
     * @param \StyleCI\StyleCI\GitHub\Branches $branches
     * @param \Pusher                          $pusher
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
    protected function trigger(Repo $repo, $event)
    {
        $branches = collect($this->branches->get($repo))->lists('name')->all();

        $this->pusher->trigger("repo-{$repo->id}", $event, ['event' => ['branches' => $branches]]);
    }
}

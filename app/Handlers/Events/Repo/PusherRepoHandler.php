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

use McCool\LaravelAutoPresenter\Facades\AutoPresenter;
use Pusher;
use StyleCI\StyleCI\Events\Repo\RepoEventInterface;
use StyleCI\StyleCI\Events\Repo\RepoWasDisabledEvent;
use StyleCI\StyleCI\Models\Repo;
use StyleCI\StyleCI\Repositories\UserRepository;

/**
 * This is the pusher repo handler class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 * @author Joseph Cohen <joe@alt-three.com>
 */
class PusherRepoHandler
{
    /**
     * The user repository instance.
     *
     * @var \StyleCI\StyleCI\Repositories\UserRepository
     */
    protected $userRepository;

    /**
     * The pusher instance.
     *
     * @var \Pusher
     */
    protected $pusher;

    /**
     * Create a new pusher repo handler instance.
     *
     * @param \StyleCI\StyleCI\Repositories\UserRepository $userRepository
     * @param \Pusher                                      $pusher
     *
     * @return void
     */
    public function __construct(UserRepository $userRepository, Pusher $pusher)
    {
        $this->userRepository = $userRepository;
        $this->pusher = $pusher;
    }

    /**
     * Handle the repo event.
     *
     * @param \StyleCI\StyleCI\Events\Repo\RepoEventInterface $event
     *
     * @return void
     */
    public function handle(RepoEventInterface $event)
    {
        if ($event instanceof RepoWasDisabledEvent) {
            $this->trigger($event->repo, 'RepoWasDisabledEvent');
        } else {
            $this->trigger($event->repo, 'RepoWasEnabledEvent');
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
        $users = $this->userRepository->collaborators($repo);
        $data = AutoPresenter::decorate($repo)->toArray();

        foreach ($users as $user) {
            $this->pusher->trigger("user-{$user->id}", $event, ['event' => $data]);
        }
    }
}

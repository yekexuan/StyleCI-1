<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Alt Three LTD <support@alt-three.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\StyleCI\Handlers\Events;

use McCool\LaravelAutoPresenter\Facades\AutoPresenter;
use StyleCI\StyleCI\Repositories\UserRepository;
use Vinkla\Pusher\PusherManager;

/**
 * This is the real time status handler class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 * @author Joseph Cohen <joe@alt-three.com>
 */
class RealTimeStatusHandler
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
     * @var \Vinkla\Pusher\PusherManager
     */
    protected $pusher;

    /**
     * Create a new analysis notifications handler instance.
     *
     * @param \StyleCI\StyleCI\Repositories\UserRepository $userRepository
     * @param \Vinkla\Pusher\PusherManager                 $pusher
     *
     * @return void
     */
    public function __construct(UserRepository $userRepository, PusherManager $pusher)
    {
        $this->userRepository = $userRepository;
        $this->pusher = $pusher;
    }

    /**
     * Handle the event.
     *
     * @param \StyleCI\StyleCI\Events\AnalysisHasStartedEvent|\StyleCI\StyleCI\Events\AnalysisHasCompletedEvent|\StyleCI\StyleCI\Events\CleanupHasCompletedEvent $event
     *
     * @return void
     */
    public function handle($event)
    {
        $analysis = AutoPresenter::decorate($event->analysis);

        $repo = $analysis->repo;

        if ($analysis->branch !== $repo->default_branch) {
            return;
        }

        $this->pusher->trigger('ch-'.$analysis->repo_id, 'AnalysisStatusUpdatedEvent', ['event' => $analysis->toArray()]);

        foreach ($this->userRepository->collaborators($repo) as $user) {
            $this->pusher->trigger('repos-'.$user->id, 'AnalysisStatusUpdatedEvent', ['event' => $analysis->toArray()]);
        }
    }
}

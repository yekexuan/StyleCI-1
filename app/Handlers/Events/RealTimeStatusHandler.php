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
use Pusher;
use StyleCI\StyleCI\Repositories\UserRepository;

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
     * @var \Pusher
     */
    protected $pusher;

    /**
     * Create a new analysis notifications handler instance.
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
     * Handle the event.
     *
     * @param \StyleCI\StyleCI\Events\AnalysisHasCompletedEvent|\StyleCI\StyleCI\Events\AnalysisHasStartedEvent|\StyleCI\StyleCI\Events\AnalysisWasQueuedEvent $event
     *
     * @return void
     */
    public function handle($event)
    {
        $repo = $event->analysis->repo;

        $analysis = AutoPresenter::decorate($event->analysis);

        $this->pusher->trigger("analysis-{$analysis->id}", 'AnalysisStatusUpdatedEvent', ['event' => $analysis->toArray()]);

        $this->pusher->trigger("repo-{$analysis->repo_id}-{$analysis->branch}", 'AnalysisStatusUpdatedEvent', ['event' => $analysis->toArray()]);

        if ($analysis->branch === $repo->default_branch) {
            foreach ($this->userRepository->collaborators($repo) as $user) {
                $this->pusher->trigger("user-{$user->id}", 'AnalysisStatusUpdatedEvent', ['event' => $analysis->toArray()]);
            }
        }
    }
}

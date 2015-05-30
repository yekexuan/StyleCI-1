<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Cachet HQ <support@cachethq.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\StyleCI\Handlers\Events;

use McCool\LaravelAutoPresenter\PresenterDecorator;
use StyleCI\StyleCI\Repositories\UserRepository;
use Vinkla\Pusher\PusherManager;

/**
 * This is the real time status handler class.
 *
 * @author Graham Campbell <graham@cachethq.io>
 * @author Joseph Cohen <joseph.cohen@dinkbit.com>
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
     * The presenter instance.
     *
     * @var \McCool\LaravelAutoPresenter\PresenterDecorator
     */
    protected $presenter;

    /**
     * Create a new analysis notifications handler instance.
     *
     * @param \StyleCI\StyleCI\Repositories\UserRepository    $userRepository
     * @param \Vinkla\Pusher\PusherManager                    $pusher
     * @param \McCool\LaravelAutoPresenter\PresenterDecorator $presenter
     *
     * @return void
     */
    public function __construct(UserRepository $userRepository, PusherManager $pusher, PresenterDecorator $presenter)
    {
        $this->userRepository = $userRepository;
        $this->pusher = $pusher;
        $this->presenter = $presenter;
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
        $commit = $this->presenter->decorate($event->commit);

        if ($commit->ref !== 'refs/heads/master') {
            return;
        }

        $this->pusher->trigger('ch-'.$commit->repo_id, 'CommitStatusUpdatedEvent', ['event' => $commit->toArray()]);

        foreach ($this->userRepository->collaborators($event->commit) as $user) {
            $this->pusher->trigger('repos-'.$user->id, 'CommitStatusUpdatedEvent', ['event' => $commit->toArray()]);
        }
    }
}

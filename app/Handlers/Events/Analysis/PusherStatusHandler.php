<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Alt Three Services Limited
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\StyleCI\Handlers\Events\Analysis;

use McCool\LaravelAutoPresenter\Facades\AutoPresenter;
use Pusher;
use StyleCI\StyleCI\Events\Analysis\AnalysisEventInterface;
use StyleCI\StyleCI\Models\Repo;
use StyleCI\StyleCI\Repositories\UserRepository;

/**
 * This is the pusher status handler class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 * @author Joseph Cohen <joe@alt-three.com>
 */
class PusherStatusHandler
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
     * Create a new pusher status handler instance.
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
     * Handle the analysis event.
     *
     * @param \StyleCI\StyleCI\Events\Analysis\AnalysisEventInterface $event
     *
     * @return void
     */
    public function handle(AnalysisEventInterface $event)
    {
        $repo = $event->analysis->repo;

        $analysis = AutoPresenter::decorate($event->analysis);

        $this->pusher->trigger("analysis-{$analysis->id}", 'AnalysisStatusUpdatedEvent', ['event' => $analysis->toArray()]);

        $this->pusher->trigger("repo-{$analysis->repo_id}", 'AnalysisStatusUpdatedEvent', ['event' => $analysis->toArray()]);

        if ($analysis->branch === $repo->default_branch) {
            $this->trigger($repo);
        }
    }

    /**
     * Trigger the notification.
     *
     * @param \StyleCI\StyleCI\Models\Repo $repo
     *
     * @return void
     */
    protected function trigger(Repo $repo)
    {
        $users = $this->userRepository->collaborators($repo);
        $data = AutoPresenter::decorate($repo)->toArray();

        foreach ($users as $user) {
            $this->pusher->trigger("user-{$user->id}", 'RepoStatusUpdatedEvent', ['event' => $data]);
        }
    }
}

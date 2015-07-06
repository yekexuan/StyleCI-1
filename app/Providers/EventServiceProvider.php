<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Alt Three Services Limited
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\StyleCI\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

/**
 * This is the event service provider class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class EventServiceProvider extends ServiceProvider
{
    /**
     * The event handler mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'StyleCI\StyleCI\Events\Analysis\AnalysisHasCompletedEvent' => [
            'StyleCI\StyleCI\Handlers\Events\Analysis\AnalysisLoggingHandler',
            'StyleCI\StyleCI\Handlers\Events\Analysis\AnalysisStatusHandler',
            'StyleCI\StyleCI\Handlers\Events\Analysis\RealTimeStatusHandler',
            'StyleCI\StyleCI\Handlers\Events\Analysis\AnalysisNotificationsHandler',
        ],
        'StyleCI\StyleCI\Events\Analysis\AnalysisHasStartedEvent' => [
            'StyleCI\StyleCI\Handlers\Events\Analysis\AnalysisLoggingHandler',
            'StyleCI\StyleCI\Handlers\Events\Analysis\AnalysisStatusHandler',
            'StyleCI\StyleCI\Handlers\Events\Analysis\RealTimeStatusHandler',
        ],
        'StyleCI\StyleCI\Events\Analysis\AnalysisWasQueuedEvent' => [
            'StyleCI\StyleCI\Handlers\Events\Analysis\AnalysisStatusHandler',
            'StyleCI\StyleCI\Handlers\Events\Analysis\RealTimeStatusHandler',
        ],
        'StyleCI\StyleCI\Events\Repo\RepoWasDisabledEvent' => [
            'StyleCI\StyleCI\Handlers\Events\Repo\WebHooksHandler',
            'StyleCI\StyleCI\Handlers\Events\Repo\RealTimeRepoHandler',
            'StyleCI\StyleCI\Handlers\Events\Repo\RepoNotificationHandler',
        ],
        'StyleCI\StyleCI\Events\Repo\RepoWasEnabledEvent' => [
            'StyleCI\StyleCI\Handlers\Events\Repo\WebHooksHandler',
            'StyleCI\StyleCI\Handlers\Events\Repo\RealTimeRepoHandler',
            'StyleCI\StyleCI\Handlers\Events\Repo\RepoNotificationHandler',
        ],
        'StyleCI\StyleCI\Events\User\UserHasLoggedInEvent' => [
            'StyleCI\StyleCI\Handlers\Events\User\AuthenticationHandler',
            'StyleCI\StyleCI\Handlers\Events\User\RepoCacheFlushHandler',
        ],
        'StyleCI\StyleCI\Events\User\UserHasRageQuitEvent' => [
            'StyleCI\StyleCI\Handlers\Events\User\RevokeTokenHandler',
            'StyleCI\StyleCI\Handlers\Events\User\GoodbyeMessageHandler',
        ],
        'StyleCI\StyleCI\Events\User\UserHasSignedUpEvent' => [
            'StyleCI\StyleCI\Handlers\Events\User\WelcomeMessageHandler',
        ],
    ];
}

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
            'StyleCI\StyleCI\Handlers\Events\Analysis\PusherStatusHandler',
            'StyleCI\StyleCI\Handlers\Events\Analysis\AnalysisMailHandler',
        ],
        'StyleCI\StyleCI\Events\Analysis\AnalysisHasStartedEvent' => [
            'StyleCI\StyleCI\Handlers\Events\Analysis\AnalysisLoggingHandler',
            'StyleCI\StyleCI\Handlers\Events\Analysis\AnalysisStatusHandler',
            'StyleCI\StyleCI\Handlers\Events\Analysis\PusherStatusHandler',
        ],
        'StyleCI\StyleCI\Events\Analysis\AnalysisWasQueuedEvent' => [
            'StyleCI\StyleCI\Handlers\Events\Analysis\AnalysisStatusHandler',
            'StyleCI\StyleCI\Handlers\Events\Analysis\PusherStatusHandler',
        ],
        'StyleCI\StyleCI\Events\Repo\GitHub\GitHubCreateEvent' => [
            'StyleCI\StyleCI\Handlers\Events\Repo\BranchCacheFlushHandler',
            'StyleCI\StyleCI\Handlers\Events\Repo\PusherBranchHandler',
        ],
        'StyleCI\StyleCI\Events\Repo\GitHub\GitHubDeleteEvent' => [
            'StyleCI\StyleCI\Handlers\Events\Repo\BranchCacheFlushHandler',
            'StyleCI\StyleCI\Handlers\Events\Repo\AnalysisCacheFlushHandler',
            'StyleCI\StyleCI\Handlers\Events\Repo\PusherBranchHandler',
        ],
        'StyleCI\StyleCI\Events\Repo\GitHub\GitHubMemberEvent' => [
            'StyleCI\StyleCI\Handlers\Events\Repo\CollaboratorCacheFlushHandler',
        ],
        'StyleCI\StyleCI\Events\Repo\GitHub\GitHubPingEvent' => [
            'StyleCI\StyleCI\Handlers\Events\Repo\GitHub\GitHubPingHandler',
        ],
        'StyleCI\StyleCI\Events\Repo\GitHub\GitHubPullRequestEvent' => [
            'StyleCI\StyleCI\Handlers\Events\Repo\AnalysisCacheFlushHandler',
            'StyleCI\StyleCI\Handlers\Events\Repo\GitHub\GitHubPullRequestHandler',
        ],
        'StyleCI\StyleCI\Events\Repo\GitHub\GitHubPushEvent' => [
            'StyleCI\StyleCI\Handlers\Events\Repo\BranchCacheFlushHandler',
            'StyleCI\StyleCI\Handlers\Events\Repo\GitHub\GitHubPushHandler',
        ],
        'StyleCI\StyleCI\Events\Repo\GitHub\GitHubTeamAddEvent' => [
            'StyleCI\StyleCI\Handlers\Events\Repo\CollaboratorCacheFlushHandler',
        ],
        'StyleCI\StyleCI\Events\Repo\RepoWasDisabledEvent' => [
            'StyleCI\StyleCI\Handlers\Events\Repo\WebhookHandler',
            'StyleCI\StyleCI\Handlers\Events\Repo\PusherRepoHandler',
            'StyleCI\StyleCI\Handlers\Events\Repo\RepoMailHandler',
            'StyleCI\StyleCI\Handlers\Events\Repo\BranchCacheFlushHandler',
            'StyleCI\StyleCI\Handlers\Events\Repo\CollaboratorCacheFlushHandler',
        ],
        'StyleCI\StyleCI\Events\Repo\RepoWasEnabledEvent' => [
            'StyleCI\StyleCI\Handlers\Events\Repo\WebhookHandler',
            'StyleCI\StyleCI\Handlers\Events\Repo\PusherRepoHandler',
            'StyleCI\StyleCI\Handlers\Events\Repo\RepoMailHandler',
        ],
        'StyleCI\StyleCI\Events\User\UserHasLoggedInEvent' => [
            'StyleCI\StyleCI\Handlers\Events\User\AuthenticationHandler',
            'StyleCI\StyleCI\Handlers\Events\User\RepoCacheFlushHandler',
        ],
        'StyleCI\StyleCI\Events\User\UserHasRageQuitEvent' => [
            'StyleCI\StyleCI\Handlers\Events\User\RevokeTokenHandler',
            'StyleCI\StyleCI\Handlers\Events\User\GoodbyeMailHandler',
        ],
        'StyleCI\StyleCI\Events\User\UserHasSignedUpEvent' => [
            'StyleCI\StyleCI\Handlers\Events\User\WelcomeMailHandler',
        ],
    ];
}

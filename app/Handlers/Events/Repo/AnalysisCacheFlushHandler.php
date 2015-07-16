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

use StyleCI\Cache\CacheResolver;
use StyleCI\StyleCI\Events\Repo\GitHub\GitHubDeleteEvent;
use StyleCI\StyleCI\Events\Repo\GitHub\GitHubEventInterface;
use StyleCI\StyleCI\Events\Repo\GitHub\GitHubPullRequestEvent;

/**
 * This is the analysis cache flush handler class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class AnalysisCacheFlushHandler
{
    /**
     * The cache resolver instance.
     *
     * @var \StyleCI\Cache\CacheResolver
     */
    protected $cache;

    /**
     * Create a new analysis cache flush handler instance.
     *
     * @param \StyleCI\Cache\CacheResolver $cache
     *
     * @return void
     */
    public function __construct(CacheResolver $cache)
    {
        $this->cache = $cache;
    }

    /**
     * Handle the github repo event.
     *
     * @param \StyleCI\StyleCI\Events\Repo\GitHub\GitHubDeleteEvent|\StyleCI\StyleCI\Events\Repo\GitHub\GitHubPullRequestEvent $event
     *
     * @return void
     */
    public function handle(GitHubEventInterface $event)
    {
        if ($event instanceof GitHubDeleteEvent && $this->event->data['ref_type'] === 'branch') {
            $this->cache->flush($event->repo->id, 'branch.'.$event->data['ref']);
        } elseif ($event instanceof GitHubPullRequestEvent && $this->event->data['pull_request']['merged']) {
            $this->cache->flush($event->repo->id, 'pr.'.$event->data['number']);
        }
    }
}

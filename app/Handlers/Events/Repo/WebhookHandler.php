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

use Exception;
use StyleCI\StyleCI\Events\Repo\RepoEventInterface;
use StyleCI\StyleCI\Events\Repo\RepoWasEnabledEvent;
use StyleCI\StyleCI\GitHub\Hooks;
use Throwable;

/**
 * This is the webhook handler class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class WebhookHandler
{
    /**
     * The hooks instance.
     *
     * @var \StyleCI\StyleCI\GitHub\Hooks
     */
    protected $hooks;

    /**
     * Create a new webhook handler instance.
     *
     * @param \StyleCI\StyleCI\GitHub\Hooks $hooks
     *
     * @return void
     */
    public function __construct(Hooks $hooks)
    {
        $this->hooks = $hooks;
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
        $repo = $event->repo;

        try {
            $this->hooks->disable($repo);
        } catch (Exception $e) {
            //
        } catch (Throwable $e) {
            //
        }

        if ($event instanceof RepoWasEnabledEvent) {
            $this->hooks->enable($repo);
        }
    }
}

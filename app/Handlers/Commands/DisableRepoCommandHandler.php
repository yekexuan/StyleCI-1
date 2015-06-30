<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Alt Three LTD <support@alt-three.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\StyleCI\Handlers\Commands;

use StyleCI\Storage\Stores\StoreInterface;
use StyleCI\StyleCI\Commands\DisableRepoCommand;
use StyleCI\StyleCI\Events\RepoWasDisabledEvent;

/**
 * This is the disable repo command handler class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class DisableRepoCommandHandler
{
    /**
     * The diff storage instance.
     *
     * @var \StyleCI\Storage\Stores\StoreInterface
     */
    protected $storage;

    /**
     * Create a new disable repo command handler instance.
     *
     * @param \StyleCI\Storage\Stores\StoreInterface $storage
     *
     * @return void
     */
    public function __construct(StoreInterface $storage)
    {
        $this->storage = $storage;
    }

    /**
     * Handle the disable repo command.
     *
     * @param \StyleCI\StyleCI\Commands\DisableRepoCommand $command
     *
     * @return void
     */
    public function handle(DisableRepoCommand $command)
    {
        $repo = $command->repo;

        foreach ($repo->analyses as $analysis) {
            $this->storage->delete($analysis->id);
            $analysis->delete();
        }

        event(new RepoWasDisabledEvent($repo));

        $repo->delete();
    }
}

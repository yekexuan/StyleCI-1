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

use StyleCI\StyleCI\Events\Repo\RepoEventInterface;
use StyleCI\StyleCI\GitHub\Branches;

/**
 * This is the branch cache flush handler class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class BranchCacheFlushHandler
{
    /**
     * The branches instance.
     *
     * @var \StyleCI\StyleCI\GitHub\Branches
     */
    protected $branches;

    /**
     * Create a new branch cache flush handler instance.
     *
     * @param \StyleCI\StyleCI\GitHub\Branches $branches
     *
     * @return void
     */
    public function __construct(Branches $branches)
    {
        $this->branches = $branches;
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
        $this->branches->flush($event->repo);
    }
}

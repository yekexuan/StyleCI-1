<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Cachet HQ <support@cachethq.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\StyleCI\Commands;

use StyleCI\StyleCI\Models\Repo;

/**
 * This is the disable repo command class.
 *
 * @author Graham Campbell <graham@cachethq.io>
 */
class DisableRepoCommand
{
    /**
     * The repository to delete.
     *
     * @var \StyleCI\StyleCI\Models\Repo
     */
    protected $repo;

    /**
     * Create a new disable repo command instance.
     *
     * @param \StyleCI\StyleCI\Models\Repo $repo
     *
     * @return void
     */
    public function __construct(Repo $repo)
    {
        $this->repo = $repo;
    }

    /**
     * Get the repository to delete.
     *
     * @return \StyleCI\StyleCI\Models\Repo
     */
    public function getRepo()
    {
        return $this->repo;
    }
}

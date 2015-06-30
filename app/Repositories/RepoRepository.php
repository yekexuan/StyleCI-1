<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Alt Three LTD <support@alt-three.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\StyleCI\Repositories;

use StyleCI\StyleCI\GitHub\Repos;
use StyleCI\StyleCI\Models\Repo;
use StyleCI\StyleCI\Models\User;

/**
 * This is the repo repository class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class RepoRepository
{
    /**
     * The github repos instance.
     *
     * @var \StyleCI\StyleCI\GitHub\Repos
     */
    protected $repos;

    /**
     * Create a new repo repository instance.
     *
     * @param \StyleCI\StyleCI\GitHub\Repos $repos
     *
     * @return void
     */
    public function __construct(Repos $repos)
    {
        $this->repos = $repos;
    }

    /**
     * Find all repos a user can view.
     *
     * @param \StyleCI\StyleCI\Models\User $user
     * @param bool                         $admin
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function allByUser(User $user, $admin = false)
    {
        return Repo::whereIn('id', array_keys($this->repos->get($user, $admin)))->orderBy('name', 'asc')->get();
    }
}

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

use Illuminate\Database\Eloquent\Model;
use StyleCI\StyleCI\GitHub\Collaborators;
use StyleCI\StyleCI\Models\User;

/**
 * This is the user repository class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class UserRepository
{
    /**
     * The collaborators instance.
     *
     * @var \StyleCI\StyleCI\GitHub\Collaborators
     */
    protected $collaborators;

    /**
     * Create a new user repository instance.
     *
     * @param \StyleCI\StyleCI\GitHub\Collaborators $collaborators
     *
     * @return void
     */
    public function __construct(Collaborators $collaborators)
    {
        $this->collaborators = $collaborators;
    }

    /**
     * Find all users marked as collaborators to the provided model.
     *
     * @param \Illuminate\Database\Eloquent\Model
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function collaborators(Model $model)
    {
        return User::whereIn('id', $this->collaborators->get($model))->get();
    }
}

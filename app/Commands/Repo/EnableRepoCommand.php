<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Alt Three Services Limited
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\StyleCI\Commands\Repo;

use StyleCI\StyleCI\Models\User;

/**
 * This is the enable repo command class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
final class EnableRepoCommand
{
    /**
     * The repo id.
     *
     * @var int
     */
    public $id;

    /**
     * The repo name.
     *
     * @var string
     */
    public $name;

    /**
     * The default branch.
     *
     * @var string
     */
    public $branch;

    /**
     * The associated user.
     *
     * @var \StyleCI\StyleCI\Models\User
     */
    public $user;

    /**
     * The validation rules.
     *
     * @var array
     */
    public $rules = [
        'id'     => 'required|integer|min:1',
        'name'   => 'required|string|between:3,255',
        'branch' => 'required|string|between:1,255',
    ];

    /**
     * Create a new enable repo command instance.
     *
     * @param int                          $id
     * @param string                       $name
     * @param string                       $branch
     * @param \StyleCI\StyleCI\Models\User $user
     *
     * @return void
     */
    public function __construct($id, $name, $branch, User $user)
    {
        $this->id = $id;
        $this->name = $name;
        $this->branch = $branch;
        $this->user = $user;
    }
}

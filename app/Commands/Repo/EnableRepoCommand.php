<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Alt Three LTD <support@alt-three.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\StyleCI\Commands\Repo;

/**
 * This is the enable repo command class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class EnableRepoCommand
{
    /**
     * The repository id.
     *
     * @var int
     */
    public $id;

    /**
     * The repository name.
     *
     * @var string
     */
    public $name;

    /**
     * The associated user.
     *
     * @var int
     */
    public $user;

    /**
     * Create a new enable repo command instance.
     *
     * @param int    $id
     * @param string $name
     * @param int    $user
     *
     * @return void
     */
    public function __construct($id, $name, $user)
    {
        $this->id = $id;
        $this->name = $name;
        $this->user = $user;
    }
}

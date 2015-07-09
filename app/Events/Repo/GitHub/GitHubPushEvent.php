<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Alt Three Services Limited
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\StyleCI\Events\Repo\GitHub;

use StyleCI\StyleCI\Models\Repo;

/**
 * This is the github push event class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
final class GitHubPushEvent implements GitHubEventInterface
{
    /**
     * The repo object.
     *
     * @var \StyleCI\StyleCI\Models\Repo
     */
    public $repo;

    /**
     * The event data.
     *
     * @var array
     */
    public $data;

    /**
     * Create a new github push event instance.
     *
     * @param \StyleCI\StyleCI\Models\Repo $repo
     * @param array                        $data
     *
     * @return void
     */
    public function __construct(Repo $repo, array $data)
    {
        $this->repo = $repo;
        $this->data = $data;
    }
}

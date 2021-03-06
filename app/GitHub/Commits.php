<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Alt Three Services Limited
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\StyleCI\GitHub;

use StyleCI\StyleCI\Models\Repo;

/**
 * This is the github commits class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class Commits
{
    /**
     * The github client factory instance.
     *
     * @var \StyleCI\StyleCI\GitHub\ClientFactory
     */
    protected $factory;

    /**
     * Create a new github commits instance.
     *
     * @param \StyleCI\StyleCI\GitHub\ClientFactory $factory
     *
     * @return void
     */
    public function __construct(ClientFactory $factory)
    {
        $this->factory = $factory;
    }

    /**
     * Get information about a specific commit from github.
     *
     * @param \StyleCI\StyleCI\Models\Repo $repo
     * @param string                       $commit
     *
     * @return array
     */
    public function get(Repo $repo, $commit)
    {
        $args = explode('/', $repo->name);

        $client = $this->factory->make($repo);

        return $client->repos()->commits()->show($args[0], $args[1], $commit);
    }
}

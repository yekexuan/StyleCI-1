<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Alt Three LTD <support@alt-three.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\StyleCI\GitHub;

use Github\ResultPager;
use InvalidArugmentException;
use StyleCI\StyleCI\Models\Repo;

/**
 * This is the github branches class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class Branches
{
    /**
     * The github client factory instance.
     *
     * @var \StyleCI\StyleCI\GitHub\ClientFactory
     */
    protected $factory;

    /**
     * Create a new github branches instance.
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
     * Get the branches from a github repo.
     *
     * @param \StyleCI\StyleCI\Models\Repo $repo
     *
     * @return array
     */
    public function get(Repo $repo)
    {
        $branches = [];

        foreach ($this->getRaw($repo) as $raw) {
            if ((strpos($raw['name'], 'gh-pages') === false)) {
                $branches[] = ['name' => $raw['name'], 'commit' => $raw['commit']['sha']];
            }
        }

        return $branches;
    }

    /**
     * Get the last commit to a branch.
     *
     * @param \StyleCI\StyleCI\Models\Repo $repo
     * @param string                       $branch
     *
     * @throws \InvalidArugmentException
     *
     * @return string
     */
    public function getCommit(Repo $repo, $branch)
    {
        foreach ($this->getRaw($repo) as $raw) {
            if ($branch === $raw['name']) {
                return $raw['commit']['sha'];
            }
        }

        throw new InvalidArugmentException('No such branch exists on the repo.');
    }

    /**
     * Get the raw branch list from github.
     *
     * @param \StyleCI\StyleCI\Models\Repo $repo
     *
     * @return array
     */
    protected function getRaw(Repo $repo)
    {
        $client = $this->factory->make($repo, ['version' => 'quicksilver-preview']);
        $paginator = new ResultPager($client);

        return $paginator->fetchAll($client->repos(), 'branches', explode('/', $repo->name));
    }
}

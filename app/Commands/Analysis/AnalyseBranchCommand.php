<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Alt Three LTD <support@alt-three.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\StyleCI\Commands\Analysis;

use StyleCI\StyleCI\Models\Repo;

/**
 * This is the analyse branch command.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class AnalyseBranchCommand
{
    /**
     * The repo to analyse.
     *
     * @var \StyleCI\StyleCI\Models\Repo
     */
    public $repo;

    /**
     * The branch to analyse.
     *
     * @var string
     */
    public $branch;

    /**
     * The validation rules.
     *
     * @var array
     */
    public $rules = [
        'branch' => 'required|string|between:1,255',
    ];

    /**
     * Create a new analyse branch command instance.
     *
     * @param \StyleCI\StyleCI\Models\Repo $repo
     * @param string                       $branch
     *
     * @return void
     */
    public function __construct(Repo $repo, $branch)
    {
        $this->repo = $repo;
        $this->branch = $branch;
    }
}

<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Alt Three Services Limited
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\StyleCI\Commands\Analysis;

use StyleCI\StyleCI\Models\Repo;

/**
 * This is the analyze branch command.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
final class AnalyzeBranchCommand
{
    /**
     * The repo to analyze.
     *
     * @var \StyleCI\StyleCI\Models\Repo
     */
    public $repo;

    /**
     * The branch to analyze.
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
     * Create a new analyze branch command instance.
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

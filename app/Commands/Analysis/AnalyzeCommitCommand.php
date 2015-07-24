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
 * This is the analyze commit command.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
final class AnalyzeCommitCommand
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
     * The commit to analyze.
     *
     * @var string
     */
    public $commit;

    /**
     * The commit message.
     *
     * @var string
     */
    public $message;

    /**
     * The validation rules.
     *
     * @var array
     */
    public $rules = [
        'branch'  => 'required|string|between:1,255',
        'commit'  => 'required|string|size:40',
        'message' => 'required|string|between:1,255',
    ];

    /**
     * Create a new analyze commit command instance.
     *
     * @param \StyleCI\StyleCI\Models\Repo $repo
     * @param string                       $branch
     * @param string                       $commit
     * @param string                       $message
     *
     * @return void
     */
    public function __construct(Repo $repo, $branch, $commit, $message)
    {
        $this->repo = $repo;
        $this->branch = $branch;
        $this->commit = $commit;
        $this->message = $message;
    }
}

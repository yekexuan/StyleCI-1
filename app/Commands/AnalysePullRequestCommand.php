<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Alt Three LTD <support@alt-three.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\StyleCI\Commands;

/**
 * This is the analyse pull request command.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class AnalysePullRequestCommand
{
    /**
     * The repo to analyse.
     *
     * @var int
     */
    public $repo;

    /**
     * The pr to analyse.
     *
     * @var int
     */
    public $pr;

    /**
     * The commit to analyse.
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
     * Create a new analyse commit command instance.
     *
     * @param int    $repo
     * @param int    $pr
     * @param string $commit
     * @param string $message
     *
     * @return void
     */
    public function __construct($repo, $pr, $commit, $message)
    {
        $this->repo = $repo;
        $this->pr = $pr;
        $this->commit = $commit;
        $this->message = $message;
    }
}

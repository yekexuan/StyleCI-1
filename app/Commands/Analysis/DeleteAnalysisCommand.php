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

use StyleCI\StyleCI\Models\Analysis;

/**
 * This is the delete analysis command.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
final class DeleteAnalysisCommand
{
    /**
     * The analysis to delete.
     *
     * @var \StyleCI\StyleCI\Models\Analysis
     */
    public $analysis;

    /**
     * Create a new delete analysis command instance.
     *
     * @param \StyleCI\StyleCI\Models\Analysis $analysis
     *
     * @return void
     */
    public function __construct(Analysis $analysis)
    {
        $this->analysis = $analysis;
    }
}

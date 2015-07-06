<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Alt Three Services Limited
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\StyleCI\Handlers\Events\Analysis;

use StyleCI\StyleCI\Events\Analysis\AnalysisEventInterface;
use StyleCI\StyleCI\GitHub\Status;

/**
 * This is the analysis status handler class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class AnalysisStatusHandler
{
    /**
     * The status instance.
     *
     * @var \StyleCI\StyleCI\GitHub\Status
     */
    protected $status;

    /**
     * Create a new analysis status handler instance.
     *
     * @param \StyleCI\StyleCI\GitHub\Status $status
     *
     * @return void
     */
    public function __construct(Status $status)
    {
        $this->status = $status;
    }

    /**
     * Handle the analysis event.
     *
     * @param \StyleCI\StyleCI\Events\Analysis\AnalysisEventInterface $event
     *
     * @return void
     */
    public function handle(AnalysisEventInterface $event)
    {
        $this->status->push($event->analysis);
    }
}

<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Cachet HQ <support@cachethq.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\StyleCI\Events;

use Exception;
use Illuminate\Queue\SerializesModels;

/**
 * This is the analysis has errored event class.
 *
 * @author Graham Campbell <graham@cachethq.io>
 */
class AnalysisHasErroredEvent
{
    use SerializesModels;

    /**
     * The exception that occurred during analysis.
     *
     * @var \Exception
     */
    public $exception;

    /**
     * Create a new analysis has errored event instance.
     *
     * @param \Exception $exception
     *
     * @return void
     */
    public function __construct(Exception $exception)
    {
        $this->exception = $exception;
    }
}

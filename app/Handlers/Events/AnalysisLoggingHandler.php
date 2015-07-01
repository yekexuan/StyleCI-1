<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Alt Three LTD <support@alt-three.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\StyleCI\Handlers\Events;

use McCool\LaravelAutoPresenter\Facades\AutoPresenter;
use Psr\Log\LoggerInterface;
use StyleCI\StyleCI\Events\AnalysisHasCompletedEvent;
use StyleCI\StyleCI\Models\Analysis;

/**
 * This is the analysis logging handler class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class AnalysisLoggingHandler
{
    /**
     * The logger instance.
     *
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * Create a new analysis logging handler instance.
     *
     * @param \Psr\Log\LoggerInterface $logger
     *
     * @return void
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * Handle the event.
     *
     * @param \StyleCI\StyleCI\Events\AnalysisHasStartedEvent|\StyleCI\StyleCI\Events\AnalysisHasCompletedEvent $event
     *
     * @return void
     */
    public function handle($event)
    {
        $analysis = $event->analysis;

        if (isset($event->exception)) {
            $this->logger->notice($event->exception);
        }

        $this->logState($analysis);
    }

    /**
     * Log the state of the analysis.
     *
     * @param \StyleCI\StyleCI\Models\Analysis
     *
     * @return void
     */
    protected function logState(Analysis $analysis)
    {
        switch ($analysis->status) {
            case 0:
                $this->logger->debug("Analysis of {$analysis->commit} has started.", $this->getContext('Analysis started.', $analysis));
                break;
            case 1:
            case 2:
                $this->logger->debug("Analysis of {$analysis->commit} has completed successfully.", $this->getContext('Analysis completed.', $analysis));
                break;
            case 3:
                $this->logger->error("Analysis of {$analysis->commit} has failed due to an internal error.", $this->getContext('Analysis errored.', $analysis));
                break;
            case 4:
                $this->logger->notice("Analysis of {$analysis->commit} has failed due to misconfiguration.", $this->getContext('Analysis misconfigured.', $analysis));
                break;
        }
    }

    /**
     * Get the context.
     *
     * @param string                           $title
     * @param \StyleCI\StyleCI\Models\Analysis $analysis
     *
     * @return array
     */
    protected function getContext($title, Analysis $analysis)
    {
        return ['title' => $title, 'analysis' => AutoPresenter::decorate($analysis)->toArray()];
    }
}

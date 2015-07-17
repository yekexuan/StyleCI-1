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

use McCool\LaravelAutoPresenter\Facades\AutoPresenter;
use Psr\Log\LoggerInterface;
use StyleCI\StyleCI\Events\Analysis\AnalysisEventInterface;
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
     * Handle the analysis event.
     *
     * @param \StyleCI\StyleCI\Events\Analysis\AnalysisEventInterface $event
     *
     * @return void
     */
    public function handle(AnalysisEventInterface $event)
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
                $this->logger->debug('Analysis has been queued.', $this->getContext($analysis));
                break;
            case 1:
                $this->logger->debug('Analysis has started running.', $this->getContext($analysis));
                break;
            case 2:
            case 3:
            case 4:
            case 5:
                $this->logger->debug('Analysis has completed successfully.', $this->getContext($analysis));
                break;
            case 6:
                $this->logger->notice('Analysis has failed due to misconfiguration.', $this->getContext($analysis));
                break;
            default:
                $this->logger->error('Analysis has failed due to an internal error.', $this->getContext($analysis));
        }
    }

    /**
     * Get the context.
     *
     * @param \StyleCI\StyleCI\Models\Analysis $analysis
     *
     * @return array
     */
    protected function getContext(Analysis $analysis)
    {
        return ['analysis' => AutoPresenter::decorate($analysis)->toArray()];
    }
}

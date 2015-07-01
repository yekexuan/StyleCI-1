<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Alt Three LTD <support@alt-three.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\StyleCI\Handlers\Commands;

use Exception;
use StyleCI\Config\Exceptions\ConfigExceptionInterface;
use StyleCI\Fixer\ReportBuilder;
use StyleCI\Git\Exceptions\GitExceptionInterface;
use StyleCI\Storage\Stores\StoreInterface;
use StyleCI\StyleCI\Commands\RunAnalysisCommand;
use StyleCI\StyleCI\Events\AnalysisHasCompletedEvent;
use StyleCI\StyleCI\Events\AnalysisHasStartedEvent;
use StyleCI\StyleCI\Models\Analysis;

/**
 * This is the run analysis command handler.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class RunAnalysisCommandHandler
{
    /**
     * The report builder instance.
     *
     * @var \StyleCI\Fixer\ReportBuilder
     */
    protected $builder;

    /**
     * The diff storage instance.
     *
     * @var \StyleCI\Storage\Stores\StoreInterface
     */
    protected $storage;

    /**
     * Create a new run analysis command handler instance.
     *
     * @param \StyleCI\Fixer\ReportBuilder           $builder
     * @param \StyleCI\Storage\Stores\StoreInterface $storage
     *
     * @return void
     */
    public function __construct(ReportBuilder $builder, StoreInterface $storage)
    {
        $this->builder = $builder;
        $this->storage = $storage;
    }

    /**
     * Handle the run analysis command.
     *
     * @param \StyleCI\StyleCI\Commands\RunAnalysisCommand $command
     *
     * @return void
     */
    public function handle(RunAnalysisCommand $command)
    {
        $analysis = $command->analysis;

        // bail out if the repo is already analysed or canceled
        if ($analysis->status > 1) {
            return;
        }

        $analysis->status = 1;

        event(new AnalysisHasStartedEvent($analysis));

        try {
            $this->runAnalysis($analysis);
        } catch (ConfigExceptionInterface $e) {
            $analysis->status = 4;
            $analysis->error = $e->getMessage();
        } catch (GitExceptionInterface $e) {
            $analysis->status = 5;
        } catch (Exception $e) {
            $analysis->status = 7;
        }

        $analysis->save();

        if (isset($e)) {
            event(new AnalysisHasCompletedEvent($analysis, $e));
        } else {
            event(new AnalysisHasCompletedEvent($analysis));
        }
    }

    /**
     * Run the analysis.
     *
     * @param \StyleCI\StyleCI\Models\Analysis $analysis
     *
     * @return void
     */
    protected function runAnalysis(Analysis $analysis)
    {
        $report = $this->builder->analyse($analysis->repo->name, $analysis->repo->id, $analysis->commit);

        if ($report->successful()) {
            $analysis->status = 2;
        } else {
            $analysis->status = 3;
            $this->storage->put($analysis->id, $report->diff());
        }
    }
}

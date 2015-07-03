<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Alt Three LTD <support@alt-three.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\StyleCI\Handlers\Jobs\Analysis;

use Exception;
use StyleCI\Config\Exceptions\ConfigExceptionInterface;
use StyleCI\Fixer\ReportBuilder;
use StyleCI\Git\Exceptions\GitExceptionInterface;
use StyleCI\Storage\Stores\StoreInterface;
use StyleCI\StyleCI\Events\Analysis\AnalysisHasCompletedEvent;
use StyleCI\StyleCI\Events\Analysis\AnalysisHasStartedEvent;
use StyleCI\StyleCI\Jobs\Analysis\RunAnalysisJob;
use StyleCI\StyleCI\Models\Analysis;

/**
 * This is the run analysis job handler.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class RunAnalysisJobHandler
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
     * Create a new run analysis job handler instance.
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
     * Handle the run analysis job.
     *
     * @param \StyleCI\StyleCI\Jobs\Analysis\RunAnalysisJob $job
     *
     * @return void
     */
    public function handle(RunAnalysisJob $job)
    {
        $analysis = $job->analysis;

        // bail out if the repo is already analysed or canceled
        if ($analysis->status > 1) {
            return;
        }

        $analysis->status = 1;

        event(new AnalysisHasStartedEvent($analysis));

        try {
            $this->runAnalysis($analysis);
        } catch (ConfigExceptionInterface $e) {
            $analysis->status = 6;
            $analysis->error = $e->getMessage();
        } catch (GitExceptionInterface $e) {
            $analysis->status = 7;
        } catch (Exception $e) {
            $analysis->status = 9;
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
        $report = $this->builder->analyse(
            $analysis->repo->name,
            $analysis->repo->id,
            $analysis->commit,
            $analysis->branch,
            $analysis->pr,
            $analysis->repo->default_branch
        );

        if ($errors = $report->errors()) {
            $analysis->status = 9;
            $analysis->errors = $errors;

            return;
        }

        $successful = $report->successful();
        $lints = $report->lints();

        if ($successful && $lints) {
            $analysis->status = 4;
            $analysis->errors = $lints;
        } elseif (!$successful && $lints) {
            $analysis->status = 5;
            $analysis->errors = $lints;
        } elseif ($successful && !$lints) {
            $analysis->status = 2;
        } else {
            $analysis->status = 3;
        }

        if (!$successful) {
            $this->storage->put($analysis->id, $report->diff());
        }
    }
}

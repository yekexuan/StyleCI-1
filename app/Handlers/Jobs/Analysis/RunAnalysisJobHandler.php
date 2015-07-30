<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Alt Three Services Limited
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\StyleCI\Handlers\Jobs\Analysis;

use Exception;
use Gitonomy\Git\Exception\GitExceptionInterface as GitonomyException;
use GitWrapper\GitException as GitWrapperException;
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

        if ($analysis->status > Analysis::PENDING) {
            return;
        }

        $analysis->status = Analysis::RUNNING;

        $analysis->save();

        event(new AnalysisHasStartedEvent($analysis));

        try {
            $this->runAnalysis($analysis);
        } catch (ConfigExceptionInterface $e) {
            $analysis->status = Analysis::CONFIG_ISSUES;
            $analysis->error = $e->getMessage();
        } catch (GitExceptionInterface $e) {
            $analysis->status = Analysis::ACCESS_ISSUES;
        } catch (GitonomyException $e) {
            $analysis->status = Analysis::ACCESS_ISSUES;
        } catch (GitWrapperException $e) {
            $analysis->status = Analysis::ACCESS_ISSUES;
        } catch (Exception $e) {
            $analysis->status = Analysis::INTERNAL;
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
        $report = $this->builder->analyze(
            $analysis->repo->name,
            $analysis->repo->id,
            $analysis->commit,
            $analysis->branch,
            $analysis->pr,
            $analysis->repo->default_branch
        );

        if ($errors = $report->errors()) {
            $analysis->status = Analysis::INTERNAL;
            $analysis->errors = $errors;

            return;
        }

        $successful = $report->successful();
        $lints = $report->lints();

        if ($successful && $lints) {
            $analysis->status = Analysis::SYNTAX_ISSUES;
            $analysis->errors = $lints;
        } elseif (!$successful && $lints) {
            $analysis->status = Analysis::BOTH_ISSUES;
            $analysis->errors = $lints;
        } elseif ($successful && !$lints) {
            $analysis->status = Analysis::PASSED;
        } else {
            $analysis->status = Analysis::CS_ISSUES;
        }

        if (!$successful) {
            $this->storage->put($analysis->id, $report->diff());
        }
    }
}

<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Alt Three Services Limited
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\StyleCI\GitHub;

use McCool\LaravelAutoPresenter\Facades\AutoPresenter;
use StyleCI\StyleCI\Models\Analysis;
use StyleCI\StyleCI\Presenters\AnalysisPresenter;

/**
 * This is the github status class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class Status
{
    /**
     * The github client factory instance.
     *
     * @var \StyleCI\StyleCI\GitHub\ClientFactory
     */
    protected $factory;

    /**
     * Create a new github status instance.
     *
     * @param \StyleCI\StyleCI\GitHub\ClientFactory $factory
     *
     * @return void
     */
    public function __construct(ClientFactory $factory)
    {
        $this->factory = $factory;
    }

    /**
     * Push the status on the github analysis.
     *
     * @param \StyleCI\StyleCI\Models\Analysis $analysis
     *
     * @return void
     */
    public function push(Analysis $analysis)
    {
        $repo = $analysis->repo;
        $args = explode('/', $repo->name);
        $decorated = AutoPresenter::decorate($analysis);

        $data = [
            'state'       => $this->getState($decorated->status),
            'description' => $this->getDescription($decorated),
            'target_url'  => route('analysis', $decorated->id),
            'context'     => 'StyleCI',
        ];

        $client = $this->factory->make($repo);

        $client->repos()->statuses()->create($args[0], $args[1], $analysis->commit, $data);
    }

    /**
     * Get the description of the analysis for GitHub.
     *
     * @param \StyleCI\StyleCI\Presenters\AnalysisPresenter $decorated
     *
     * @return string
     */
    protected function getDescription(AnalysisPresenter $decorated)
    {
        $description = $decorated->description;

        if ($decorated->has_diff) {
            $count = $decorated->diff->count();
            $description .= " - {$count} ".($count === 1 ? 'file needs' : 'files need').' addressing';
        }

        return $description;
    }

    /**
     * Get the state of the analysis by from its status int.
     *
     * @param int $status
     *
     * @return string
     */
    protected function getState($status)
    {
        switch ($status) {
            case Analysis::PENDING:
            case Analysis::RUNNING:
                return 'pending';
            case Analysis::PASSED:
                return 'success';
            case Analysis::CS_ISSUES:
            case Analysis::SYNTAX_ISSUES:
            case Analysis::BOTH_ISSUES:
                return 'failure';
            default:
                return 'error';
        }
    }
}

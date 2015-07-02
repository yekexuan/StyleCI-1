<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Alt Three LTD <support@alt-three.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\StyleCI\GitHub;

use McCool\LaravelAutoPresenter\Facades\AutoPresenter;
use StyleCI\StyleCI\Models\Analysis;

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

        $data = [
            'state'       => $this->getState($analysis->status),
            'description' => AutoPresenter::decorate($analysis)->description,
            'target_url'  => route('analysis_path', $analysis->id),
            'context'     => 'StyleCI',
        ];

        $client = $this->factory->make($repo, ['version' => 'quicksilver-preview']);

        $client->repos()->statuses()->create($args[0], $args[1], $analysis->commit, $data);
    }

    /**
     * Get the state of the analysis by from its status integer.
     *
     * @param int $status
     *
     * @return string
     */
    protected function getState($status)
    {
        switch ($status) {
            case 0:
            case 1:
                return 'pending';
            case 2:
                return 'success';
            case 3:
            case 4:
            case 5:
                return 'failure';
            default:
                return 'error';
        }
    }
}

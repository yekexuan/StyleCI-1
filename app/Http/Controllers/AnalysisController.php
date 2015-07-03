<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Alt Three LTD <support@alt-three.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\StyleCI\Http\Controllers;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
use McCool\LaravelAutoPresenter\Facades\AutoPresenter;
use StyleCI\StyleCI\Models\Analysis;

/**
 * This is the analysis controller class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class AnalysisController extends AbstractController
{
    /**
     * Handles the request to show an analysis.
     *
     * @param \StyleCI\StyleCI\Models\Analysis $analysis
     *
     * @return \Illuminate\View\View
     */
    public function handleShow(Analysis $analysis)
    {
        if (Request::ajax()) {
            return View::make('results')->withAnalysis($analysis);
        }

        return View::make('analysis')->withAnalysis($analysis);
    }

    /**
     * Handles the request to show a diff.
     *
     * @param \StyleCI\StyleCI\Models\Analysis $analysis
     *
     * @return \Illuminate\Http\Response
     */
    public function handleDiff(Analysis $analysis)
    {
        return Response::make(AutoPresenter::decorate($analysis)->raw_diff)
            ->header('Content-Type', 'text/plain; charset=UTF-8');
    }

    /**
     * Handles the request to download a diff.
     *
     * @param \StyleCI\StyleCI\Models\Analysis $analysis
     *
     * @return \Illuminate\Http\Response
     */
    public function handleDiffDownload(Analysis $analysis)
    {
        return Response::make(AutoPresenter::decorate($analysis)->raw_diff)
            ->header('Content-Type', 'text/plain; charset=UTF-8')
            ->header('Content-Disposition', 'attachment; filename=patch.txt');
    }
}

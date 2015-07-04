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

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use McCool\LaravelAutoPresenter\Facades\AutoPresenter;
use StyleCI\StyleCI\Models\Analysis;
use StyleCI\StyleCI\Models\Repo;

/**
 * This is the shield controller class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 * @author James Brooks <jbrooksuk@me.com>
 */
class ShieldController extends AbstractController
{
    /**
     * Handles a request to serve a shield.
     *
     * @param \StyleCI\StyleCI\Models\Repo $repo
     *
     * @return \Illuminate\Http\Response
     */
    public function handle(Repo $repo)
    {
        return Redirect::to($this->generateShieldUrl($repo->last_completed, Request::get('style', 'flat-square')));
    }

    /**
     * Generate a shields.io url for the analysis status.
     *
     * @param \StyleCI\StyleCI\Models\Analysis|null $analysis
     * @param string                                $style
     *
     * @return string
     */
    protected function generateShieldUrl(Analysis $analysis = null, $style = 'flat-square')
    {
        $color = 'lightgrey';
        $status = 'unknown';

        if ($analysis) {
            $status = strtolower(AutoPresenter::decorate($analysis)->summary);
            if ($analysis->status === 2) {
                $color = 'brightgreen';
            } elseif ($analysis->status > 2) {
                $color = 'red';
            }
        }

        return vsprintf('https://img.shields.io/badge/%s-%s-%s.svg?style=%s', ['StyleCI', $status, $color, $style]);
    }
}

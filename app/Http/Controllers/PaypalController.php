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

use Illuminate\Support\Facades\View;

/**
 * This is the home controller class.
 *
 * @author James Brooks <jbrooksuk@me.com>
 */
class PaypalController extends AbstractController
{
    /**
     * Handles the request to view the donate page.
     *
     * @return \Illuminate\View\View
     */
    public function handleDonate()
    {
        return View::make('donations.index');
    }

    /**
     * Handles the request to view the thanks for donating page.
     *
     * @return \Illuminate\View\View
     */
    public function handleThanks()
    {
        return View::make('donations.thanks');
    }

    /**
     * Handles the request to view the cancel donation page.
     *
     * @return \Illuminate\View\View
     */
    public function handleCancel()
    {
        return View::make('donations.cancel');
    }
}

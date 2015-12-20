<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Alt Three Services Limited
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\StyleCI\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use StyleCI\StyleCI\Commands\User\DeleteAccountCommand;
use StyleCI\StyleCI\Http\Middleware\Authenticate;

/**
 * This is the account controller class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class AccountController extends Controller
{
    /**
     * Create a new account controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(Authenticate::class);
    }

    /**
     * Show the user's account information.
     *
     * @return \Illuminate\View\View
     */
    public function handleShow()
    {
        return View::make('account.index');
    }

    /**
     * Delete the user's account and all their repos.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleDelete()
    {
        dispatch(new DeleteAccountCommand(Auth::user()));

        return Redirect::route('home')->with('success', 'Your account has been successfully deleted!');
    }
}

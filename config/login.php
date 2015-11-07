<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Alt Three Services Limited
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

return [

    /*
    |--------------------------------------------------------------------------
    | Client ID
    |--------------------------------------------------------------------------
    |
    | This is your application client id.
    |
    */

    'id' => env('GITHUB_CLIENT_ID'),

    /*
    |--------------------------------------------------------------------------
    | Client Secret
    |--------------------------------------------------------------------------
    |
    | This is your application client secret.
    |
    */

    'secret' => env('GITHUB_CLIENT_SECRET'),

    /*
    |--------------------------------------------------------------------------
    | Redirection URL
    |--------------------------------------------------------------------------
    |
    | This is where github sends people to after authenticating.
    |
    */

    'redirect' => env('APP_URL').'/auth/github-callback',

    /*
    |--------------------------------------------------------------------------
    | Allowed Users
    |--------------------------------------------------------------------------
    |
    | This defines list of allowed users. Empty means allow everyone.
    |
    | Default to [].
    |
    */

    'allowed' => [],

];

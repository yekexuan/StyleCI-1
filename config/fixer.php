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
    | The Timeout
    |--------------------------------------------------------------------------
    |
    | Here you may specify the analysis timeout. Set this to false to not have
    | a timeout. Also note that no timeout will be set unless the needed pcntl
    | functions are available.
    |
    */

    'timeout' => 1800,

    /*
    |--------------------------------------------------------------------------
    | Profiling
    |--------------------------------------------------------------------------
    |
    | Here you may specify if blackfire profiling is enabled. Note that if the
    | blackfire extension is not installed, enabling profiling will do nothing.
    |
    */

    'profiling' => false,

    /*
    |--------------------------------------------------------------------------
    | Client ID
    |--------------------------------------------------------------------------
    |
    | Here you may specify the blackfire client id to use.
    |
    */

    'client_id' => null,

    /*
    |--------------------------------------------------------------------------
    | Client Token
    |--------------------------------------------------------------------------
    |
    | Here you may specify the blackfire client token to use.
    |
    */

    'client_token' => null,

];

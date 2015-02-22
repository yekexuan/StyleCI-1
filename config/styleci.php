<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Graham Campbell <graham@mineuk.com>
 * (c) Joseph Cohen <joseph.cohen@dinkbit.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

return [

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

    /*
    |--------------------------------------------------------------------------
    | Enable Donations
    |--------------------------------------------------------------------------
    |
    | Paypal donations can be turned on and off from here.
    |
    | Default to true.
    |
    */

    'paypalDonate' => true,

    /*
    |--------------------------------------------------------------------------
    | Paypal ID
    |--------------------------------------------------------------------------
    |
    | The "hosted_button_id" for the Paypal donation form.
    |
    | This will only do anything if the donate config is set to true.
    |
    */

    'paypalHostedButtonId' => '',

];

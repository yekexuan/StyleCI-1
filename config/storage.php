<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Alt Three LTD <support@alt-three.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

return [

    /*
    |--------------------------------------------------------------------------
    | Default Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the connections below you wish to use as
    | your default connection for all work. Of course, you may use many
    | connections at once using the manager class.
    |
    */

    'default' => 'default',

    /*
    |--------------------------------------------------------------------------
    | Storage Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the connections setup for your application. The
    | flysystem setting tells us which of your configured flysystem connections
    | to use. The cache setting tells which cache driver to use. You can set
    | this to false to disabled caching. The encryption setting tells us if you
    | want us to encrypt your data in the storage. Note that data stored in the
    | cache is not encrypted either way.
    |
    */

    'connections' => [

        'default' => [
            'flysystem'   => 'local',
            'cache'       => env('CACHE_DRIVER', 'file'),
            'encryption'  => false,
            'compression' => false,
        ],

    ],

];

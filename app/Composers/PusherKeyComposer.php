<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Alt Three Services Limited
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\StyleCI\Composers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Config;

/**
 * This is the pusher key composer class.
 *
 * @author Graham Campbell <joe@alt-three.com>
 */
class PusherKeyComposer
{
    /**
     * Bind data to the view.
     *
     * @param \Illuminate\Contracts\View\View $view
     *
     * @return void
     */
    public function compose(View $view)
    {
        $connection = Config::get('pusher.connection', 'main');

        $key = Config::get("pusher.connections.{$connection}.auth_key");

        $view->withPusherKey($key);
    }
}

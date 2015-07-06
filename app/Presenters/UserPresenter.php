<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Alt Three Services Limited
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\StyleCI\Presenters;

use Illuminate\Database\Eloquent\Collection;
use McCool\LaravelAutoPresenter\BasePresenter;

/**
 * This is the user presenter class.
 *
 * @property int        $id
 * @property string     $name
 * @property string     $username
 * @property string     $email
 * @property string     $token
 * @property Collection $repos
 * @property string     $gravatar
 * @property string     $first_name
 *
 * @author Graham Campbell <graham@alt-three.com>
 * @author Joseph Cohen <joe@alt-three.com>
 */
class UserPresenter extends BasePresenter
{
    /**
     * Get the user's Gravatar URL.
     *
     * @param int $size
     *
     * @return string
     */
    public function gravatar($size = 200)
    {
        return sprintf('https://www.gravatar.com/avatar/%s?size=%d', md5($this->wrappedObject->email), $size);
    }

    /**
     * Get the user's first name.
     *
     * @return string
     */
    public function first_name()
    {
        return explode(' ', $this->wrappedObject->name)[0];
    }
}

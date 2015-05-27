<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Cachet HQ <support@cachethq.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\StyleCI\Events;

use Illuminate\Queue\SerializesModels;
use StyleCI\StyleCI\Models\User;

/**
 * This is the user signed up event class.
 *
 * @author Graham Campbell <graham@cachethq.io>
 */
class UserHasSignedUpEvent
{
    use SerializesModels;

    /**
     * The user that has signed up.
     *
     * @var \StyleCI\StyleCI\Models\User
     */
    public $user;

    /**
     * Create a new user has signed up event instance.
     *
     * @param \StyleCI\StyleCI\Models\User $user
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }
}

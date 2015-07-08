<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Alt Three Services Limited
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\StyleCI\Handlers\Commands\User;

use StyleCI\StyleCI\Commands\User\LoginCommand;
use StyleCI\StyleCI\Events\User\UserHasLoggedInEvent;
use StyleCI\StyleCI\Events\User\UserHasSignedUpEvent;
use StyleCI\StyleCI\Models\User;

/**
 * This is the login command handler class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 * @author Joseph Cohen <joe@alt-three.com>
 */
class LoginCommandHandler
{
    /**
     * Handle the login command.
     *
     * @param \StyleCI\StyleCI\Commands\User\LoginCommand $command
     *
     * @return void
     */
    public function handle(LoginCommand $command)
    {
        $user = User::find($command->id);

        $attributes = [
            'name'     => $command->name,
            'email'    => $command->email,
            'username' => $command->username,
            'token'    => $command->token,
        ];

        if ($user) {
            $user->fill($attributes);
        } else {
            $user = new User(array_merge(['id' => $command->id], $attributes));
            event(new UserHasSignedUpEvent($user));
        }

        $user->save();

        event(new UserHasLoggedInEvent($user));
    }
}

<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Alt Three LTD <support@alt-three.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\StyleCI\Handlers\Commands;

use StyleCI\StyleCI\Commands\LoginCommand;
use StyleCI\StyleCI\Events\UserHasLoggedInEvent;
use StyleCI\StyleCI\Events\UserHasSignedUpEvent;
use StyleCI\StyleCI\Models\User;
use StyleCI\StyleCI\Repositories\UserRepository;

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
     * @param \StyleCI\StyleCI\Commands\LoginCommand $command
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
            $user->forceFill($attributes)->save();
            event(new UserHasLoggedInEvent($user));
        } else {
            $user = User::forceCreate(array_merge(['id' => $command->id], $attributes));
            event(new UserHasSignedUpEvent($user));
        }
    }
}

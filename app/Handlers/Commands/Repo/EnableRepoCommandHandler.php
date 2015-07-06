<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Alt Three LTD <support@alt-three.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\StyleCI\Handlers\Commands\Repo;

use Illuminate\Support\Str;
use StyleCI\StyleCI\Commands\Repo\EnableRepoCommand;
use StyleCI\StyleCI\Events\Repo\RepoWasEnabledEvent;
use StyleCI\StyleCI\Models\Repo;

/**
 * This is the enable repo command handler class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class EnableRepoCommandHandler
{
    /**
     * Handle the enable repo command.
     *
     * @param \StyleCI\StyleCI\Commands\Repo\EnableRepoCommand $command
     *
     * @return void
     */
    public function handle(EnableRepoCommand $command)
    {
        $repo = Repo::create([
            'id'             => $command->id,
            'name'           => $command->name,
            'user_id'        => $command->user->id,
            'default_branch' => $command->branch,
            'token'          => bin2hex(Str::randomBytes(10)),
        ]);

        event(new RepoWasEnabledEvent($repo));
    }
}

<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Alt Three Services Limited
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\StyleCI\Handlers\Events\Repo;

use StyleCI\StyleCI\Events\Repo\RepoEventInterface;
use StyleCI\StyleCI\GitHub\Collaborators;

/**
 * This is the collaborator cache flush handler class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class CollaboratorCacheFlushHandler
{
    /**
     * The collaborators instance.
     *
     * @var \StyleCI\StyleCI\GitHub\Collaborators
     */
    protected $collaborators;

    /**
     * Create a new collaborator cache flush handler instance.
     *
     * @param \StyleCI\StyleCI\GitHub\Collaborators $collaborators
     *
     * @return void
     */
    public function __construct(Collaborators $collaborators)
    {
        $this->collaborators = $collaborators;
    }

    /**
     * Handle the repo event.
     *
     * @param \StyleCI\StyleCI\Events\Repo\RepoEventInterface $event
     *
     * @return void
     */
    public function handle(RepoEventInterface $event)
    {
        $this->collaborators->flush($event->repo);
    }
}

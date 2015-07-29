<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Alt Three Services Limited
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\StyleCI\Handlers\Commands\Analysis;

use StyleCI\Storage\Stores\StoreInterface;
use StyleCI\StyleCI\Commands\Analysis\DeleteAnalysisCommand;
use StyleCI\StyleCI\Models\Analysis;

/**
 * This is the delete analysis command handler.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class DeleteAnalysisCommandHandler
{
    /**
     * The diff storage instance.
     *
     * @var \StyleCI\Storage\Stores\StoreInterface
     */
    protected $storage;

    /**
     * Create a new delete analysis command handler instance.
     *
     * @param \StyleCI\Storage\Stores\StoreInterface $storage
     *
     * @return void
     */
    public function __construct(StoreInterface $storage)
    {
        $this->storage = $storage;
    }

    /**
     * Handle the delete analysis command.
     *
     * @param \StyleCI\StyleCI\Commands\Analysis\DeleteAnalysisCommand $command
     *
     * @return void
     */
    public function handle(DeleteAnalysisCommand $command)
    {
        $analysis = $command->analysis;

        if (in_array($analysis->status, Analysis::HAS_DIFF, true)) {
            $this->storage->delete($analysis->id);
        }

        $analysis->delete();
    }
}

<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Cachet HQ <support@cachethq.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\StyleCI\Presenters;

use Illuminate\Contracts\Support\Arrayable;
use McCool\LaravelAutoPresenter\BasePresenter;
use McCool\LaravelAutoPresenter\Facades\AutoPresenter;

/**
 * This is the repo presenter class.
 *
 * @author Graham Campbell <graham@cachethq.io>
 * @author Joseph Cohen <joseph.cohen@dinkbit.com>
 */
class RepoPresenter extends BasePresenter implements Arrayable
{
    /**
     * Convert presented repo to an array.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'id'          => $this->wrappedObject->id,
            'name'        => $this->wrappedObject->name,
            'last_commit' => $this->wrappedObject->lastCommit ? AutoPresenter::decorate($this->wrappedObject->lastCommit)->toArray() : null,
            'link'        => route('repo_path', $this->wrappedObject->id),
        ];
    }
}

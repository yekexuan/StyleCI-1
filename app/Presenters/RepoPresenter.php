<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Alt Three LTD <support@alt-three.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\StyleCI\Presenters;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Collection;
use McCool\LaravelAutoPresenter\BasePresenter;
use McCool\LaravelAutoPresenter\Facades\AutoPresenter;

/**
 * This is the repo presenter class.
 *
 * @property int                    $id
 * @property int                    $user_id
 * @property UserPresenter          $user
 * @property Collection             $analyses
 * @property AnalysisPresenter|null $last_analysis
 * @property string                 $name
 * @property string                 $default_branch
 * @property string                 $token
 *
 * @author Graham Campbell <graham@alt-three.com>
 * @author Joseph Cohen <joe@alt-three.com>
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
            'id'            => $this->wrappedObject->id,
            'name'          => $this->wrappedObject->name,
            'last_analysis' => AutoPresenter::decorate($this->wrappedObject->last_analysis)->toArray(),
            'link'          => route('repo_path', $this->wrappedObject->id),
        ];
    }
}

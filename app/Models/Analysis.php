<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Alt Three LTD <support@alt-three.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\StyleCI\Models;

use AltThree\Validator\ValidatingTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use McCool\LaravelAutoPresenter\HasPresenter;
use StyleCI\StyleCI\Presenters\AnalysisPresenter;

/**
 * This is the analysis model class.
 *
 * @property int         $id
 * @property int         $repo_id
 * @property Repo        $repo
 * @property string|null $branch
 * @property int|null    $pr
 * @property string      $commit
 * @property string      $message
 * @property string|null $error
 * @property array|null  $errors
 * @property int         $status
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class Analysis extends Model implements HasPresenter
{
    use ValidatingTrait;

    /**
     * A list of methods protected from mass assignment.
     *
     * @var string[]
     */
    protected $guarded = ['_token', '_method'];

    /**
     * The attributes that should be casted to native types.
     *
     * @var string[]
     */
    protected $casts = [
        'id'      => 'int',
        'repo_id' => 'int',
        'branch'  => 'string',
        'pr'      => 'int',
        'commit'  => 'string',
        'message' => 'string',
        'error'   => 'string',
        'errors'  => 'array',
        'status'  => 'int',
    ];

    /**
     * The validation rules.
     *
     * @var string[]
     */
    public $rules = [
        'id'      => 'integer|min:1',
        'repo_id' => 'required|integer|min:1',
        'branch'  => 'string|between:1,255',
        'pr'      => 'integer|min:1',
        'commit'  => 'required|string|size:40',
        'message' => 'required|string|between:1,255',
        'error'   => 'string|max:255',
        'errors'  => 'string',
        'status'  => 'integer|between:0,9',
    ];

    /**
     * Scope the query to only include analyses over 2 hours old.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOld(Builder $query)
    {
        return $query->where('updated_at', '<=', Carbon::now()->subHours(2));
    }

    /**
     * Scope the query to only include pending analyses.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePending(Builder $query)
    {
        return $query->where('status', '<', 2);
    }

    /**
     * Scope the query to only include pending completed.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCompleted(Builder $query)
    {
        return $query->where('status', '>', 1);
    }

    /**
     * Get the repo relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function repo()
    {
        return $this->belongsTo(Repo::class);
    }

    /**
     * Get the presenter class.
     *
     * @return string
     */
    public function getPresenterClass()
    {
        return AnalysisPresenter::class;
    }
}

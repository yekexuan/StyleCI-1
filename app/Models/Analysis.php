<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Alt Three Services Limited
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\StyleCI\Models;

use AltThree\Validator\ValidatingTrait;
use AltThree\Validator\ValidationException;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\MessageBag;
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
 * @property bool        $hidden
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class Analysis extends Model implements HasPresenter
{
    use ValidatingTrait;

    /**
     * The pending status code.
     *
     * @var int
     */
    const PENDING = 0;

    /**
     * The running status code.
     *
     * @var int
     */
    const RUNNING = 1;

    /**
     * The passed status code.
     *
     * @var int
     */
    const PASSED = 2;

    /**
     * The cs issues status code.
     *
     * @var int
     */
    const CS_ISSUES = 3;

    /**
     * The syntax issues status code.
     *
     * @var int
     */
    const SYNTAX_ISSUES = 4;

    /**
     * The both cs and syntax issues status code.
     *
     * @var int
     */
    const BOTH_ISSUES = 5;

    /**
     * The configuration issues status code.
     *
     * @var int
     */
    const CONFIG_ISSUES = 6;

    /**
     * The git access issues status code.
     *
     * @var int
     */
    const ACCESS_ISSUES = 7;

    /**
     * The analysis timeout status code.
     *
     * @var int
     */
    const TIMEOUT = 8;

    /**
     * The other internal issues status code.
     *
     * @var int
     */
    const INTERNAL = 9;

    /**
     * The status codes that mean the analysis has a diff.
     *
     * @var int[]
     */
    const HAS_DIFF = [self::CS_ISSUES, self::BOTH_ISSUES];

    /**
     * The status codes that mean the analysis has failed.
     *
     * @var int[]
     */
    const HAS_FAILED = [self::CS_ISSUES, self::SYNTAX_ISSUES, self::BOTH_ISSUES];

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
        'hidden'  => 'bool',
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
        'status'  => 'required|integer|between:0,9',
        'hidden'  => 'required|bool',
    ];

    /**
     * Validate the model before save.
     *
     * That this method in addition to checking the first set of rules are met.
     *
     * @throws \AltThree\Validator\ValidationException
     *
     * @return void
     */
    public function validate()
    {
        $messages = [];

        if ((bool) $this->branch === (bool) $this->pr) {
            $messages[] = 'You must provide either a branch or a pr.';
        }

        if (($this->error || $this->errors) && $this->status < self::CS_ISSUES) {
            $messages[] = 'Errors are only allowed for some status codes.';
        }

        if ($messages) {
            throw new ValidationException(new MessageBag($messages));
        }
    }

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
     * Scope the query to only include visible analyses.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeVisible(Builder $query)
    {
        return $query->where('hidden', 0);
    }

    /**
     * Scope the query to only include hidden analyses.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeHidden(Builder $query)
    {
        return $query->where('hidden', 1);
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

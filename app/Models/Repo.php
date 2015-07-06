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
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use McCool\LaravelAutoPresenter\HasPresenter;
use StyleCI\StyleCI\Presenters\RepoPresenter;

/**
 * This is the repo model class.
 *
 * @property int           $id
 * @property int           $user_id
 * @property User          $user
 * @property Collection    $analyses
 * @property Analysis|null $last_analysis
 * @property Analysis|null $last_completed
 * @property string        $name
 * @property string        $default_branch
 * @property string        $token
 *
 * @author Graham Campbell <graham@alt-three.com>
 * @author Joseph Cohen <joe@alt-three.com>
 */
class Repo extends Model implements HasPresenter
{
    use ValidatingTrait;

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * A list of methods protected from mass assignment.
     *
     * @var string[]
     */
    protected $guarded = ['_token', '_method'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var string[]
     */
    protected $hidden = ['token'];

    /**
     * The attributes that should be casted to native types.
     *
     * @var string[]
     */
    protected $casts = [
        'id'             => 'int',
        'user_id'        => 'int',
        'name'           => 'string',
        'default_branch' => 'string',
        'token'          => 'string',
    ];

    /**
     * The validation rules.
     *
     * @var string[]
     */
    public $rules = [
        'id'             => 'required|integer|min:1',
        'user_id'        => 'required|integer|min:1',
        'name'           => 'required|string|between:3,255',
        'default_branch' => 'required|string|between:1,255',
        'token'          => 'required|string|size:20',
    ];

    /**
     * Get the user relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the analyses relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function analyses()
    {
        return $this->hasMany(Analysis::class);
    }

    /**
     * Get the last analysis of the default branch.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function last_analysis()
    {
        return $this->hasOne(Analysis::class)->latest()->where('branch', $this->default_branch);
    }

    /**
     * Get the last completed analysis of the default branch.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function last_completed()
    {
        return $this->last_analysis()->completed();
    }

    /**
     * Get the presenter class.
     *
     * @return string
     */
    public function getPresenterClass()
    {
        return RepoPresenter::class;
    }
}

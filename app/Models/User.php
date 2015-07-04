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
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use McCool\LaravelAutoPresenter\HasPresenter;
use StyleCI\StyleCI\Presenters\UserPresenter;

/**
 * This is the user model class.
 *
 * @property int        $id
 * @property string     $name
 * @property string     $username
 * @property string     $email
 * @property string     $token
 * @property Collection $repos
 *
 * @author Graham Campbell <graham@alt-three.com>
 * @author Joseph Cohen <joe@alt-three.com>
 */
class User extends Model implements AuthenticatableContract, HasPresenter
{
    use Authenticatable, ValidatingTrait;

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
    protected $hidden = ['remember_token', 'token'];

    /**
     * The attributes that should be casted to native types.
     *
     * @var string[]
     */
    protected $casts = [
        'id'       => 'int',
        'name'     => 'string',
        'username' => 'string',
        'email'    => 'string',
        'token'    => 'string',
    ];

    /**
     * The validation rules.
     *
     * @var string[]
     */
    public $rules = [
        'id'       => 'required|integer|min:1',
        'name'     => 'required|string|between:1,255',
        'username' => 'required|string|between:1,255',
        'email'    => 'required|string|email|between:3,254',
        'token'    => 'required|string|size:40',
    ];

    /**
     * Get the repos relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function repos()
    {
        return $this->hasMany(Repo::class);
    }

    /**
     * Get the presenter class.
     *
     * @return string
     */
    public function getPresenterClass()
    {
        return UserPresenter::class;
    }
}

<?php

namespace App\Models;

use App\Models\Traits\Image;
use App\Models\Traits\Listable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Arr;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;


class User extends BaseModel implements
    AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract
{
    use Notifiable, HasRoles, Listable;
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_name', 'nick_name', 'email', 'password', 'avatar', 'locked_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected static $allowSortFields = ['id', 'user_name', 'nick_name', 'created_at', 'locked_at'];
    protected static $allowSearchFields = ['id', 'user_name', 'nick_name', 'email'];

    protected $dates = ['locked_at'];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function getAvatarUrlAttribute()
    {
        return $this->getImageUrl($this->attributes['avatar']);
    }

    public function isLocked()
    {
        return $this->locked_at != null;
    }
}

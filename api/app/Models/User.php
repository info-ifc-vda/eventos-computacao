<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /******************************************
     *                                        *
     *              PROPERTIES                *
     *                                        *
     ******************************************/

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'recovery_account_token',
        'recovery_account_token_created_at'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /******************************************
    *                                         *
    *               ATTRIBUTES                *
    *                                         *
    ******************************************/

    /******************************************
    *                                         *
    *                RELATIONS                *
    *                                         *
    ******************************************/

    public function permissions()
    {
        return $this->hasMany(UserPermission::class, 'user_id', 'id');
    }

    /******************************************
    *                                         *
    *                  SCOPES                 *
    *                                         *
    ******************************************/

    public function scopeSearch(Builder $query, $q) {
        if ($q) {
            $query = $query->where('email', 'like', '%'.$q.'%')->orWhere('name', 'like', '%'.$q.'%');
        }

        return $query;
    }

    /******************************************
    *                                         *
    *                 METHODS                 *
    *                                         *
    ******************************************/

    public function can($abilities, $arguments = [])
    {
        $can = $this->permissions->where('permission', $abilities)->first() ? true : false;

        // TODO: (Backlog) verificar se o cara é um admin da plataforma
        return $can;
    }
}

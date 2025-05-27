<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Builder;
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
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /******************************************
     *                                        *
     *              ATTRIBUTES                *
     *                                        *
     ******************************************/

    /******************************************
     *                                        *
     *                 SCOPES                 *
     *                                        *
     ******************************************/

    public function scopeSearch(Builder $query, $q) {
        if ($q) {
            $query = $query->where('email', 'like', '%'.$q.'%')->orWhere('name', 'like', '%'.$q.'%');
        }

        return $query;
    }

    /******************************************
     *                                        *
     *                METHODS                 *
     *                                        *
     ******************************************/
}

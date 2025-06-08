<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    // use HasUuids;
    /******************************************
     *                                        *
     *              PROPERTIES                *
     *                                        *
     ******************************************/

    public $table = 'events';

    /******************************************
     *                                        *
     *              ATTRIBUTES                *
     *                                        *
     ******************************************/

    protected $primaryKey = 'id'; // Default, can omit
    public $incrementing = true;   // Default, ensures auto-increment
    protected $keyType = 'int';   // Default, for bigint

    protected $fillable = [
        'uuid',
        'user_id',
        'title',
        'description',
        'subscription_deadline',
        'payment_deadline',
        'banner_url',
        'estimated_value',
        'created_at',
        'updated_at',
    ];

    protected function cancelled(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes) => $this->cancellation_date ? true : false
        );
    }

    /******************************************
     *                                        *
     *               RELATIONS                *
     *                                        *
     ******************************************/

    public function event_periods()
    {
        return $this->hasMany('event_periods', 'event_id', 'id');
    }

    public function organizers()
    {
        return $this->belongsToMany(User::class, 'event_organizers', 'event_id', 'user_id');
    }

    /******************************************
     *                                        *
     *                 SCOPES                 *
     *                                        *
     ******************************************/

    /******************************************
     *                                        *
     *                METHODS                 *
     *                                        *
     ******************************************/
}

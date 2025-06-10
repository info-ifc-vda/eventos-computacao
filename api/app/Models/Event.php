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
        return $this->hasMany(EventPeriod::class, 'event_id', 'id');
    }

    public function location()
    {
        return $this->hasOne(EventLocation::class, 'event_id', 'id');
    }

    public function bank_details()
    {
        return $this->hasOne(EventBankDetails::class, 'event_id', 'id');
    }

    public function participants()
    {
        return $this->hasMany(EventParticipant::class, 'event_id', 'id');
    }

    public function organizers()
    {
        return $this->hasMany(EventOrganizer::class, 'event_id', 'id');
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

    public function getBannerUrl()
    {
        return env('APP_URL').'storage/'.$this->banner_url;
    }
}

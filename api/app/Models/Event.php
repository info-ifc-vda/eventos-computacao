<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Event extends Model
{
    use HasUuids;
    /******************************************
     *                                        *
     *              PROPERTIES                *
     *                                        *
     ******************************************/

    public $table = 'events';
    public $primaryKey = 'uuid';

    /******************************************
     *                                        *
     *              ATTRIBUTES                *
     *                                        *
     ******************************************/

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
        return env('APP_URL').'/storage/'.$this->banner_url;
    }
}

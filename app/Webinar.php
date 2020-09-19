<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Webinar extends Model
{

    use SoftDeletes;

    protected $guarded = ['id'];

    protected $casts = [
        'recurrence' => 'array',
        'start_date' => 'datetime'
    ];

    //relations
    public function webinar()
    {
        return $this->belongsTo(Webinar::class);
    }

    public function webinars()
    {
        return $this->hasMany(Webinar::class);
    }


    public function saveWithoutEvents()
    {
        return static::withoutEvents(function () {
            return $this->save();
        });
    }

    public function deleteWithoutEvents()
    {
        return static::withoutEvents(function () {
            return $this->delete();
        });
    }

    public function forceDeleteWithoutEvents()
    {
        return static::withoutEvents(function () {
            return $this->forceDelete();
        });
    }
}

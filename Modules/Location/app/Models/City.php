<?php

namespace Modules\Location\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Location\Database\factories\CityFactory;

class City extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];

    function state() : BelongsTo {
        return $this->belongsTo(State::class);
    }
}

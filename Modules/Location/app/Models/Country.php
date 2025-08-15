<?php

namespace Modules\Location\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Location\Database\factories\CountryFactory;

class Country extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];

    function states() : HasMany {
        return $this->hasMany(State::class, 'country_id', 'id');
    }

}

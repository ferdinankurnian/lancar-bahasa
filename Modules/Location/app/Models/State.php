<?php

namespace Modules\Location\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Location\Database\factories\StateFactory;

class State extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];


    function country() {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }
}

<?php

namespace Modules\Customer\app\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Customer\Database\factories\BannedHistoryFactory;

class BannedHistory extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];

    protected static function newFactory(): BannedHistoryFactory
    {
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JitsiSetting extends Model {
    use HasFactory;
    protected $fillable = ['instructor_id', 'app_id', 'api_key', 'permissions'];

    function instructor(): BelongsTo {
        return $this->belongsTo(User::class, 'instructor_id', 'id')->withDefault();
    }
}

<?php

namespace Modules\InstructorRequest\app\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\InstructorRequest\Database\factories\InstructorRequestFactory;

class InstructorRequest extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'id',
        'user_id',
        'status',
        'payout_account',
        'payout_information',
        'certificate',
        'identity_scan',
        'extra_information'
    ];

    function user() : BelongsTo {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

}

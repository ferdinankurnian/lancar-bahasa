<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuizResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'quiz_id',
        'result',
        'user_grade',
        'status'
    ];

    function quiz() : BelongsTo
    {
        return $this->belongsTo(Quiz::class, 'quiz_id', 'id');
    }
}

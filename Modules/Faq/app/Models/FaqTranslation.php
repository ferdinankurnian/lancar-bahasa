<?php

namespace Modules\Faq\app\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FaqTranslation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'faq_id',
        'lang_code',
        'question',
        'answer',
    ];

    public function faq(): ?BelongsTo
    {
        return $this->belongsTo(Faq::class);
    }
}

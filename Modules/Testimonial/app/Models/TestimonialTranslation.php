<?php

namespace Modules\Testimonial\app\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TestimonialTranslation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'testimonial_id',
        'lang_code',
        'name',
        'designation',
        'comment',
    ];

    public function testimonial(): ?BelongsTo
    {
        return $this->belongsTo(Testimonial::class);
    }
}

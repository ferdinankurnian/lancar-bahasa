<?php

namespace Modules\Frontend\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SectionTranslation extends Model {
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['section_id', 'lang_code', 'content'];
    protected $casts = [
        'content' => 'array',
    ];
    public function section(): BelongsTo {
        return $this->belongsTo(Section::class, 'section_id');
    }
    /**
     * Accessor to decode JSON content when retrieving.
     */
    public function getContentAttribute($value):object|null {
        return json_decode($value);
    }
}

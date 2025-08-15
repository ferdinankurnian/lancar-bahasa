<?php

namespace Modules\Faq\app\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Faq extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['status'];

    public function getQuestionAttribute(): ?string
    {
        return $this->translation->question;
    }

    public function getAnswerAttribute(): ?string
    {
        return $this->translation->answer;
    }

    public function translation(): ?HasOne
    {
        return $this->hasOne(FaqTranslation::class)->where('lang_code', getSessionLanguage());
    }

    public function getTranslation($code): ?FaqTranslation
    {
        return $this->hasOne(FaqTranslation::class)->where('lang_code', $code)->first();
    }

    public function translations(): ?HasMany
    {
        return $this->hasMany(FaqTranslation::class, 'faq_id');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function scopeInactive($query)
    {
        return $query->where('status', 0);
    }
}

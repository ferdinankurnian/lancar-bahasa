<?php

namespace Modules\Frontend\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Modules\Frontend\Database\factories\FeaturedInstructorFactory;

class FeaturedInstructor extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['button_url', 'instructor_ids', 'id'];

    public function translation(): ?HasOne
    {
        return $this->hasOne(FeaturedInstructorTranslation::class, 'featured_instructor_section_id')->where('lang_code', getSessionLanguage());
    }

    public function getTranslation($code): ?FeaturedInstructorTranslation
    {
        return $this->hasOne(FeaturedInstructorTranslation::class, 'featured_instructor_section_id')->where('lang_code', $code)->first();
    }

    public function translations(): ?HasMany
    {
        return $this->hasMany(FeaturedInstructorTranslation::class, 'featured_instructor_section_id');
    }
    
}

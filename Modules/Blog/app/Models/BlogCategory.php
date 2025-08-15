<?php

namespace Modules\Blog\app\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class BlogCategory extends Model
{
    use HasFactory;

    protected $fillable = ['slug', 'status'];

    // make a accessor for translation
    public function getTitleAttribute(): ?string
    {
        return $this->translation->title;
    }

    public function getShortDescriptionAttribute(): ?string
    {
        return $this->translation->short_description;
    }

    public function translation(): ?HasOne
    {
        return $this->hasOne(BlogCategoryTranslation::class)->where('lang_code', getSessionLanguage());
    }

    public function getTranslation($code): ?BlogCategoryTranslation
    {
        return $this->hasOne(BlogCategoryTranslation::class)->where('lang_code', $code)->first();
    }

    public function translations(): ?HasMany
    {
        return $this->hasMany(BlogCategoryTranslation::class, 'blog_category_id');
    }

    public function posts()
    {
        return $this->hasMany(Blog::class, 'blog_category_id');
    }
}

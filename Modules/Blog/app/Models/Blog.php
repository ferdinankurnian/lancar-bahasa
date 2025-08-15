<?php

namespace Modules\Blog\app\Models;

use App\Models\Admin;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'admin_id',
        'blog_category_id',
        'slug',
        'views',
        'show_homepage',
        'is_popular',
        'tags',
        'status',
    ];

    public function getTitleAttribute(): ?string
    {
        return $this->translation->title;
    }

    public function getDescriptionAttribute(): ?string
    {
        return $this->translation->description;
    }

    public function getSeoTitleAttribute(): ?string
    {
        return $this->translation->seo_title;
    }

    public function getSeoDescriptionAttribute(): ?string
    {
        return $this->translation->seo_description;
    }

    public function category(): ?BelongsTo
    {
        return $this->belongsTo(BlogCategory::class, 'blog_category_id');
    }

    public function translation(): ?HasOne
    {
        return $this->hasOne(BlogTranslation::class)->where('lang_code', getSessionLanguage());
    }

    public function getTranslation($code): ?BlogTranslation
    {
        return $this->hasOne(BlogTranslation::class)->where('lang_code', $code)->first();
    }

    public function translations(): ?HasMany
    {
        return $this->hasMany(BlogTranslation::class, 'blog_id');
    }

    public function comments(): ?HasMany
    {
        return $this->hasMany(BlogComment::class, 'blog_id');
    }

    public function author(): ?BelongsTo
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }
}

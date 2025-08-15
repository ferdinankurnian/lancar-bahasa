<?php

namespace Modules\PageBuilder\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Modules\PageBuilder\Database\factories\CustomPageFactory;

class CustomPage extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['slug', 'status'];

    public function translation(): ?HasOne
    {
        return $this->hasOne(CustomPageTranslation::class)->where('lang_code', getSessionLanguage());
    }

    public function getTranslation($code): ?CustomPageTranslation
    {
        return $this->hasOne(CustomPageTranslation::class)->where('lang_code', $code)->first();
    }

    public function translations(): ?HasMany
    {
        return $this->hasMany(CustomPageTranslation::class, 'custom_page_id');
    }
}

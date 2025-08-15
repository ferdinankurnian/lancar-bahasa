<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


class CourseChapter extends Model {
    use HasFactory;

    protected $fillable = ['order', 'id'];

    public function chapterItems(): HasMany {
        return $this->hasMany(CourseChapterItem::class, 'chapter_id', 'id')->orderBy('order');
    }
    /**
     * Boot method to handle model events.
     */
    protected static function boot() {
        parent::boot();

        static::deleting(function ($courseChapter) {
            $courseChapter->chapterItems()->each(function ($chapterItem) {
                $chapterItem->delete();
            });
        });
    }
}

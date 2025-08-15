<?php

namespace Modules\Blog\app\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BlogComment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'comment',
        'name',
        'blog_id',
        'email',
        'status',
    ];

    public function post(): ?BelongsTo
    {
        return $this->belongsTo(Blog::class, 'blog_id');
    }

    function user() : BelongsTo{
        return $this->belongsTo(User::class, 'user_id'); 
    }
}

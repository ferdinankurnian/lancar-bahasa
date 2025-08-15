<?php

namespace Modules\Badges\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Badges\Database\factories\BadgeFactory;

class Badge extends Model
{
    use HasFactory;

    protected $guarded = [];

}

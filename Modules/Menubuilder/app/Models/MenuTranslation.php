<?php

namespace Modules\Menubuilder\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MenuTranslation extends Model
{
    protected $table = null;

    public function __construct(array $attributes = [])
    {
        $this->table = 'menu_translations';
    }

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['menu_id', 'name','lang_code'];

    public function menus(): ?BelongsTo
    {
        return $this->belongsTo(Menus::class,'menu_id');
    }
    
}

<?php

namespace Modules\Menubuilder\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MenuItemTranslation extends Model
{
    protected $table = null;

    public function __construct(array $attributes = [])
    {
        $this->table = 'menu_item_translations';
    }

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['menu_item_id','label','lang_code'];

    public function menuItems(): ?BelongsTo
    {
        return $this->belongsTo(MenuItem::class,'menu_item_id');
    }
    
}

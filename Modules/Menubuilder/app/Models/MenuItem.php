<?php

namespace Modules\Menubuilder\app\Models;

use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    protected $table = null;

    protected $fillable = ['label', 'link', 'parent_id', 'sort', 'class', 'menu_id', 'depth', 'role_id'];

    public function __construct(array $attributes = [])
    {
        //parent::construct( $attributes );
        $this->table = 'menu_items';
    }

    public function getSons($id)
    {
        return $this->where("parent_id", $id)->get();
    }
    public function getAll($id)
    {
        return $this->where("menu_id", $id)->orderBy("sort", "asc")->get();
    }

    public static function getNextSortRoot($menu)
    {
        return self::where('menu_id', $menu)->max('sort') + 1;
    }

    public function parentMenu()
    {
        return $this->belongsTo(Menus::class, 'menu_id');
    }

    public function child()
    {
        return $this->hasMany(MenuItem::class, 'parent_id')->orderBy('sort', 'ASC');
    }

    public function getLabelAttribute(): ?string
    {
        return $this->translation->label;
    }
    public function translation(): ?HasOne
    {
        return $this->hasOne(MenuItemTranslation::class)->where('lang_code', getSessionLanguage());
    }

    public function getTranslation($code): ?MenuItemTranslation
    {
        return $this->hasOne(MenuItemTranslation::class)->where('lang_code', $code)->first();
    }

    public function translations(): ?HasMany
    {
        return $this->hasMany(MenuItemTranslation::class, 'menu_item_id');
    }

}

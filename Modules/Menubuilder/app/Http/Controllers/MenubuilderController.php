<?php

namespace Modules\Menubuilder\app\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Modules\Menubuilder\app\Models\Menus;
use Modules\Menubuilder\app\Models\MenuItem;
use Modules\Language\app\Enums\TranslationModels;
use Modules\Menubuilder\app\Enums\DefaultMenusEnum;
use Modules\Language\app\Traits\GenerateTranslationTrait;

class MenubuilderController extends Controller
{
    use GenerateTranslationTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        checkAdminHasPermissionAndThrowException('menu.view');

        $menu = new Menus();
        $menuItems = new MenuItem();
        $menuList = $menu->select(['id', 'name'])->get();

        $languages = allLanguages();
        $defaultMenusList = DefaultMenusEnum::getAll();

        if ((request()->has("action") && empty(request()->input("menu"))) || request()->input("menu") == '0') {
            return view('menubuilder::index')->with(['menulist' => $menuList, 'languages' => $languages, 'defaultMenusList' => $defaultMenusList]);
        }

        if(empty(request()?->input('menu'))) {
            request()->merge(['menu' => Menus::first()->id ?? null]);
        }

        $menu = Menus::find(request()->input("menu"));
        $menus = $menuItems->getAll(request()->input("menu"));

        $data = ['menus' => $menus, 'indmenu' => $menu, 'menulist' => $menuList, 'languages' => $languages, 'defaultMenusList' => $defaultMenusList];
        if( config('menubuilder.use_roles')) {
            $data['roles'] = DB::table(config('menubuilder.roles_table'))->select([config('menubuilder.roles_pk'),config('menubuilder.roles_title_field')])->get();
            $data['role_pk'] = config('menubuilder.roles_pk');
            $data['role_title_field'] = config('menubuilder.roles_title_field');
        }
        return view('menubuilder::index',$data);
    }

    public function createMenu()
    {
        checkAdminHasPermissionAndThrowException('menu.create');
        $slug = Str::of(request()->input("menuname"))->slug('-');
        if(Menus::where('slug',$slug)->exists()){
            $slug = $slug .'-'.Str::random(5);
        }

        $menu = new Menus();
        $menu->name = request()->input("menuname");
        $menu->slug = $slug;
        $menu->save();

        request()->merge(['name' => request()->input("menuname")]);

        $this->generateTranslations(
            TranslationModels::Menu,
            $menu,
            'menu_id',
            request(),
        );
        
        $this->cacheClear();
        return json_encode(array("resp" => $menu->id));
    }

    public function deleteMenu()
    {
        checkAdminHasPermissionAndThrowException('menu.delete');
        $menus = new MenuItem();
        $all = $menus->getAll(request()->input("id"));
        if (count($all) == 0) {
            $menu = Menus::find(request()->input("id"));
            $menu->delete();

            return json_encode(array("resp" => __("deleting_this_menu")));
        }

        $this->cacheClear();
        return json_encode(array("resp" => __("delete_all_items"), "error" => 1));
    }

    public function updateMenu()
    {
        checkAdminHasPermissionAndThrowException('menu.update');
        
        $menu = Menus::find(request()->input("idmenu"));

        $code = request()->input("code");
        if($code == config('app.locale')){
            $menu->name = request()->input("menuname");
            $menu->save();
        }

        $this->updateTranslations(
            $menu,
            request(),
            ['name' => request()->input("menuname")],
        );

        if (is_array(request()->input("arraydata"))) {
            foreach (request()->input("arraydata") as $value) {
                $menuItem = MenuItem::find($value["id"]);
                $menuItem->parent_id = $value["parent"];
                $menuItem->sort = $value["sort"];
                $menuItem->depth = $value["depth"];
                if (config('menubuilder.use_roles')) {
                    $menuItem->role_id = $value["role_id"];
                }
                $menuItem->save();
            }
        }

        $this->cacheClear();

        return json_encode(array("resp" => 1));
    }

    public function deleteMenuItem()
    {
        $menuItem = MenuItem::find(request()->input("id"));
        $menuItem->delete();

        $this->cacheClear();
    }

    public function updateMenuItem()
    {
        $arrayData = request()->input("arraydata");
        if (is_array($arrayData)) {
            foreach ($arrayData as $value) {
                $menuItem = MenuItem::find($value['id']);
                $code = $value['code'];
                if($code == config('app.locale')){
                    $menuItem->label = $value['label'];
                    $menuItem->link = $value['link'];
                    if (config('menubuilder.use_roles')) {
                        $menuItem->role_id = $value['role_id'] ? $value['role_id'] : 0 ;
                    }
                    $menuItem->save();
                }

                request()->merge(['code' => $code]);

                $this->updateTranslations(
                    $menuItem,
                    request(),
                    ['label' => $value['label']],
                );
            }
        } else {
            $menuItem = MenuItem::find(request()->input("id"));
            if(request()->input("code") == config('app.locale')){
                $menuItem->label = request()->input("label");
                $menuItem->link = request()->input("url");
                $menuItem->class = request()->input("clases");
                if (config('menubuilder.use_roles')) {
                    $menuItem->role_id = request()->input("role_id") ? request()->input("role_id") : 0 ;
                }
                $menuItem->save();
            }
            
            request()->merge(['code' => request()->input("code")]);

            $this->updateTranslations(
                $menuItem,
                request(),
                ['label' => request()->input("labelmenu")],
            );
        }

        $this->cacheClear();
    }

    public function addMenuItem()
    {
        $menuItem = new MenuItem();
        $menuItem->label = request()->input("labelmenu");
        $menuItem->link = request()->input("linkmenu");
        if (config('menubuilder.use_roles')) {
            $menuItem->role_id = request()->input("rolemenu") ? request()->input("rolemenu")  : 0 ;
        }
        $menuItem->menu_id = request()->input("idmenu");
        $menuItem->sort = MenuItem::getNextSortRoot(request()->input("idmenu"));
        $menuItem->save();

        request()->merge(['label' => request()->input("labelmenu")]);

        $this->generateTranslations(
            TranslationModels::MenuItem,
            $menuItem,
            'menu_item_id',
            request(),
        );

        $this->cacheClear();

    }

    function cacheClear() {
       Cache::forget('nav_menu');
       Cache::forget('footer_menu_one');
       Cache::forget('footer_menu_two');
       Cache::forget('footer_menu_three');
    }
}

## NOTE: MenuBuilder "The Font Awesome CDN link needs to be updated.

## MenuBuilder Setup
````
php artisan module:migrate Menubuilder
php artisan module:seed Menubuilder

````

## Add your default menu item to the DefaultMenusEnum array
Navigate to `Modules/Menubuilder/app/Enums`, then open the file named `DefaultMenusEnum` and add your item.


## Using Model Class

#### menu item list by menu name 
````
$menu = Menus::where('name','Test Menu')->first();

````
#### menu item list by menu id 
````
$menu = Menus::find(1);

````
#### or get menu by name and the items with EAGER LOADING 
````
$menu = Menus::where('name','Test Menu')->with('items')->first();

````
#### or get menu by name and the items with EAGER LOADING 
````
$menu = Menus::where('id', 1)->with('items')->first();

````
#### you can access by model result
````
$public_menu = $menu->items;

````
#### or you can convert it to array
````
$public_menu = $menu->items->toArray();

````


## Or using helper

#### menu item list by menu slug 
````
menuGetBySlug('test-menu')

````
#### menu item list by menu id 
````
menuGetById(1);

````
#### menu item list by menu name 
````
menuGetByName('Test');

````


## Now inside your blade template file place the menu using this simple example

#### Using Helper  
````
$public_menu = menuGetByName('Test');; //return array

````

````
@if($public_menu)
    <ul class="menu">
        @foreach($public_menu as $menu)
        <li class="">
            <a href="{{ $menu['link'] }}" title="">{{ $menu['label'] }}</a>
            @if( $menu['child'] )
            <ul class="sub-menu">
                @foreach( $menu['child'] as $child )
                    <li class=""><a href="{{ $child['link'] }}" title="">{{ $child['label'] }}</a></li>
                @endforeach
            </ul><!-- /.sub-menu -->
            @endif
        </li>
        @endforeach
    </ul><!-- /.menu -->
@endif

````


## Static json language texts

````
{
    "select_menu" : "Select Menu",
    "Custom Menu" : "Custom Menu",
    "URL" : "URL",
    "deleting_this_menu" : "You're deleting the menu. Are you sure want to delete?",
    "delete_all_items" : "You have to delete all items first!",
    "move_up" : "Move Up",
    "move_down" : "Move Down",
    "move_top" : "Move Top",
    "move_under" : "Move under of %s",
    "move_out_from" : "Out from under %s",
    "under" : "Under %s",
    "out_from" : "Out from %s",
    "menu_focus" : "%1\\$s. Element menu %2\\$d of %3\\$d.",
    "submenu_focus": "%1\\$s. Menu of subelement %2\\$d of %3\\$s.",
    "select_menu_edit" : "Select the menu you want to edit:",
    "create_new_menu" : "Create new menu",
    "add_link" : "Add Link",
    "press_enter" : "Press return or enter to expand.",
    "label" : "Label",
    "role" : "Role",
    "select_role" : "Select Role",
    "add_menu_item" : "Add menu item",
    "name" : "Name",
    "create_menu" : "Create Menu",
    "save_menu" : "Save Menu",
    "menu_structure" : "Menu Structure",
    "menu_structure_text" : "Place each item in the order you prefer. Click on the arrow to the right of the item to display more configuration options.",
    "menu_creation" : "Menu Creation",
    "menu_creation_text" : "Please enter the name and select \"Create menu\" button.",
    "subelement" : "Subelement",
    "class_css" : "Class CSS (optional)",
    "delete" : "Delete",
    "top" : "Top",
    "cancel" : "Cancel",
    "update_item" : "Update Item",
    "delete_menu" : "Delete Menu",
    "move" : "Move",
    "enter_menu_name" : "Enter menu name",
    "menu_label" : "Menu Label",
    "or" : "or",
    "choose" : "Choose"
}
````
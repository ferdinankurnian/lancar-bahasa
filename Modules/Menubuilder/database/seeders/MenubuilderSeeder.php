<?php

namespace Modules\Menubuilder\database\seeders;

use Illuminate\Database\Seeder;

class MenubuilderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $menus = array(
            array(
                "id" => 9,
                "name" => "nav_menu",
                "slug" => "nav-menu",
                "created_at" => "2024-05-23 12:10:20",
                "updated_at" => "2024-05-23 12:10:20",
            ),
            array(
                "id" => 10,
                "name" => "footer_col_one",
                "slug" => "footer-col-one",
                "created_at" => "2024-05-26 06:25:04",
                "updated_at" => "2024-05-26 06:25:04",
            ),
            array(
                "id" => 13,
                "name" => "footer_col_two",
                "slug" => "footer-col-two-1PiTN",
                "created_at" => "2024-05-26 06:25:37",
                "updated_at" => "2024-05-26 06:25:37",
            ),
            array(
                "id" => 14,
                "name" => "footer_col_three",
                "slug" => "footer-col-three",
                "created_at" => "2024-05-26 06:32:09",
                "updated_at" => "2024-05-26 06:32:09",
            ),
        );

        $menu_translations = array(
            array(
                "id" => 7,
                "menu_id" => 9,
                "lang_code" => "en",
                "name" => "nav_menu",
                "created_at" => "2024-05-23 12:10:20",
                "updated_at" => "2024-05-23 12:10:20",
            ),
            array(
                "id" => 9,
                "menu_id" => 10,
                "lang_code" => "en",
                "name" => "footer_col_one",
                "created_at" => "2024-05-26 06:25:04",
                "updated_at" => "2024-05-26 06:25:04",
            ),
            array(
                "id" => 15,
                "menu_id" => 13,
                "lang_code" => "en",
                "name" => "footer_col_two",
                "created_at" => "2024-05-26 06:25:37",
                "updated_at" => "2024-05-26 06:25:37",
            ),
            array(
                "id" => 17,
                "menu_id" => 14,
                "lang_code" => "en",
                "name" => "footer_col_three",
                "created_at" => "2024-05-26 06:32:09",
                "updated_at" => "2024-05-26 06:32:09",
            ),
            array(
                "id" => 23,
                "menu_id" => 9,
                "lang_code" => "bn",
                "name" => "nav_menu",
                "created_at" => "2024-05-31 17:14:54",
                "updated_at" => "2024-05-31 17:14:54",
            ),
            array(
                "id" => 24,
                "menu_id" => 10,
                "lang_code" => "bn",
                "name" => "footer_col_one",
                "created_at" => "2024-05-31 17:14:54",
                "updated_at" => "2024-05-31 17:14:54",
            ),
            array(
                "id" => 25,
                "menu_id" => 13,
                "lang_code" => "bn",
                "name" => "footer_col_two",
                "created_at" => "2024-05-31 17:14:54",
                "updated_at" => "2024-05-31 17:14:54",
            ),
            array(
                "id" => 26,
                "menu_id" => 14,
                "lang_code" => "bn",
                "name" => "footer_col_three",
                "created_at" => "2024-05-31 17:14:54",
                "updated_at" => "2024-05-31 17:14:54",
            ),
            array(
                "id" => 27,
                "menu_id" => 9,
                "lang_code" => "hi",
                "name" => "nav_menu",
                "created_at" => "2024-05-31 17:15:13",
                "updated_at" => "2024-05-31 17:15:13",
            ),
            array(
                "id" => 28,
                "menu_id" => 10,
                "lang_code" => "hi",
                "name" => "footer_col_one",
                "created_at" => "2024-05-31 17:15:13",
                "updated_at" => "2024-05-31 17:15:13",
            ),
            array(
                "id" => 29,
                "menu_id" => 13,
                "lang_code" => "hi",
                "name" => "footer_col_two",
                "created_at" => "2024-05-31 17:15:13",
                "updated_at" => "2024-05-31 17:15:13",
            ),
            array(
                "id" => 30,
                "menu_id" => 14,
                "lang_code" => "hi",
                "name" => "footer_col_three",
                "created_at" => "2024-05-31 17:15:13",
                "updated_at" => "2024-05-31 17:15:13",
            ),
        );
        
        
       \DB::table('menus')->insert($menus); 
       \DB::table('menu_translations')->insert($menu_translations);
    }
}
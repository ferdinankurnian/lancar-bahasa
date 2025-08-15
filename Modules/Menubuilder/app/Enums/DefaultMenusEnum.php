<?php

namespace Modules\Menubuilder\app\Enums;

use Illuminate\Support\Collection;

enum DefaultMenusEnum: string {
    public static function getAll(): Collection {
        $all_default_menus = [
            (object) [
                'name' => __('Home'),
                'url' => '/',
            ],
            (object) [
                'name' => __('Courses'),
                'url' => '/courses',
            ],
            (object) [
                'name' => __('Blog'),
                'url' => '/blog',
            ],
            (object) [
                'name' => __('About Us'),
                'url' => '/about-us',
            ],
            (object) [
                'name' => __('Contact'),
                'url' => '/contact',
            ],
            (object) [
                'name' => __('All Instructors'),
                'url' => '/all-instructors',
            ],
        ];
        return collect( $all_default_menus );
    }
}

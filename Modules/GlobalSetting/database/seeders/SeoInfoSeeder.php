<?php

namespace Modules\GlobalSetting\database\seeders;

use Illuminate\Database\Seeder;
use Modules\GlobalSetting\app\Models\SeoSetting;

class SeoInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $item1 = new SeoSetting();
        $item1->page_name = 'home_page';
        $item1->seo_title = 'Home || WebSolutionUS';
        $item1->seo_description = 'Home || WebSolutionUS';
        $item1->save();

        $item2 = new SeoSetting();
        $item2->page_name = 'about_page';
        $item2->seo_title = 'About || WebSolutionUS';
        $item2->seo_description = 'About || WebSolutionUS';
        $item2->save();

        $item2 = new SeoSetting();
        $item2->page_name = 'course_page';
        $item2->seo_title = 'Course || WebSolutionUS';
        $item2->seo_description = 'Course || WebSolutionUS';
        $item2->save();

        $item2 = new SeoSetting();
        $item2->page_name = 'blog_page';
        $item2->seo_title = 'Blog || WebSolutionUS';
        $item2->seo_description = 'Blog || WebSolutionUS';
        $item2->save();

        $item2 = new SeoSetting();
        $item2->page_name = 'contact_page';
        $item2->seo_title = 'Contact || WebSolutionUS';
        $item2->seo_description = 'Contact || WebSolutionUS';
        $item2->save();
    }
}

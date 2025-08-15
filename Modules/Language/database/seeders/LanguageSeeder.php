<?php

namespace Modules\Language\database\seeders;

use Illuminate\Database\Seeder;
use Modules\Language\app\Models\Language;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $language = new Language();
        $language->name = 'English';
        $language->code = 'en';
        $language->is_default = true;
        $language->save();

        $language = new Language();
        $language->name = 'Hindi';
        $language->code = 'hi';
        $language->save();

        $language = new Language();
        $language->name = 'Arabic';
        $language->code = 'ar';
        $language->direction = 'rtl';
        $language->save();
    }
}

<?php

namespace Modules\GlobalSetting\database\seeders;

use Illuminate\Database\Seeder;
use Modules\GlobalSetting\app\Models\MarketingSetting;

class MarketingSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $setting_data = [
            'register' => 1,
            'course_details' => 1,
            'add_to_cart' => 1,
            'remove_from_cart' => 1,
            'checkout' => 1,
            'order_success' => 1,
            'order_failed' => 1,
            'contact_page' => 1,
            'instructor_contact' => 1,
        ];

        foreach ($setting_data as $index => $setting_item) {
            MarketingSetting::updateOrCreate(['key' => $index], ['value' => $setting_item]);
        }
    }
}

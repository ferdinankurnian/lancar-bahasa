<?php

namespace Modules\Testimonial\database\seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Modules\Testimonial\app\Models\Testimonial;
use Modules\Testimonial\app\Models\TestimonialTranslation;

class TestimonialDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 0; $i < 20; $i++) {
            $data = new Testimonial();
            $data->image = "website/images/client_img_{$faker->randomElement(['1', '2', '3'])}.jpg" ?? $faker->imageUrl;
            $data->rating = $faker->numberBetween(1, 5);
            $data->status = $faker->randomElement([true, false]);
            if ($data->save()) {
                foreach (allLanguages() as $language) {
                    $dataTranslation = new TestimonialTranslation();
                    $dataTranslation->lang_code = $language->code;
                    $dataTranslation->testimonial_id = $data->id;
                    $dataTranslation->name = $faker->firstName;
                    $dataTranslation->designation = $faker->jobTitle;
                    $dataTranslation->comment = $faker->paragraph;
                    $dataTranslation->save();
                }
            }
        }
    }
}
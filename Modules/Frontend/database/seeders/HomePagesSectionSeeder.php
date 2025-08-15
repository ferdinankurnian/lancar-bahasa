<?php

namespace Modules\Frontend\database\seeders;

use App\Enums\ThemeList;
use Illuminate\Database\Seeder;
use Modules\Frontend\app\Models\Home;

class HomePagesSectionSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        $home_pages = [
            [
                'slug'     => ThemeList::MAIN->value,
                'sections' => [
                    [
                        'name'           => 'hero_section',
                        'global_content' => [
                            'action_button_url'     => '/courses',
                            'video_button_url'      => 'https://www.youtube.com/watch?v=pMzGDBP6Bic',
                            'banner_image'          => 'uploads/custom-images/wsus-img-2024-06-26-06-06-24-6800.png',
                            'banner_background'     => 'uploads/custom-images/wsus-img-2024-06-03-09-44-49-7136.png',
                            'hero_background'       => 'uploads/custom-images/wsus-img-2024-06-23-04-25-27-8319.png',
                            'enroll_students_image' => 'uploads/custom-images/wsus-img-2024-06-03-09-44-49-4396.png',
                        ],
                    ],
                    [
                        'name'           => 'about_section',
                        'global_content' => [
                            'button_url' => '/about-us',
                            'video_url'  => 'https://www.youtube.com/watch?v=VkBnNxneA_A',
                            'image'      => 'uploads/custom-images/wsus-img-2024-06-03-07-17-53-5562.png',
                        ],
                    ],
                    [
                        'name'           => 'newsletter_section',
                        'global_content' => [
                            'image' => 'uploads/custom-images/wsus-img-2024-06-04-11-18-08-2099.png',
                        ],
                    ],
                    [
                        'name'           => 'counter_section',
                        'global_content' => [
                            'total_student_count'    => 3000,
                            'total_instructor_count' => 100,
                            'total_courses_count'    => 800,
                            'total_awards_count'     => 50,
                        ],
                    ],
                    [
                        'name'           => 'faq_section',
                        'global_content' => [
                            'image' => 'uploads/custom-images/wsus-img-2024-06-04-11-35-48-7341.png',
                        ],
                    ],
                    [
                        'name'           => 'our_features_section',
                        'global_content' => [
                            'image_one'   => 'uploads/custom-images/wsus-img-2024-06-11-05-27-50-9263.png',
                            'image_two'   => 'uploads/custom-images/wsus-img-2024-06-11-05-49-32-6821.png',
                            'image_three' => 'uploads/custom-images/wsus-img-2024-06-23-05-11-29-2802.png',
                            'image_four'  => 'uploads/custom-images/wsus-img-2024-06-11-05-27-50-7828.png',
                        ],
                    ],
                    [
                        'name'           => 'banner_section',
                        'global_content' => [
                            'instructor_image' => 'uploads/custom-images/wsus-img-2024-06-04-11-44-52-4232.png',
                            'student_image'    => 'uploads/custom-images/wsus-img-2024-06-04-11-44-52-8789.png',
                        ],
                    ],
                ],
            ],
            [
                'slug'     => ThemeList::ONLINE->value,
                'sections' => [
                    [
                        'name'           => 'hero_section',
                        'global_content' => [
                            'action_button_url'     => '/courses',
                            'video_button_url'      => 'https://www.youtube.com/watch?v=pMzGDBP6Bic',
                            'banner_image'          => 'uploads/custom-images/theme_online_banner_img.png',
                            'banner_background'     => 'uploads/custom-images/theme_online_banner_bg.svg',
                            'hero_background'       => 'uploads/custom-images/theme_online_hero_bg.png',
                            'enroll_students_image' => 'uploads/custom-images/theme_online_enroll_students_image.png',
                        ],
                    ],
                    [
                        'name'           => 'about_section',
                        'global_content' => [
                            'button_url' => '/about-us',
                            'video_url'  => 'https://www.youtube.com/watch?v=VkBnNxneA_A',
                            'image'      => 'uploads/custom-images/theme_online_about_img.png',
                        ],
                    ],
                    [
                        'name'           => 'newsletter_section',
                        'global_content' => [
                            'image' => 'uploads/custom-images/theme_online_newsletter.png',
                        ],
                    ],
                    [
                        'name'           => 'counter_section',
                        'global_content' => [
                            'total_student_count'    => 3000,
                            'total_courses_count'    => 800,
                            'total_instructor_count' => 100,
                        ],
                    ],
                    [
                        'name'           => 'faq_section',
                        'global_content' => [
                            'image' => 'uploads/custom-images/theme_online_faq.png',
                        ],
                    ],
                    [
                        'name'           => 'our_features_section',
                        'global_content' => [
                            'image_one'   => 'uploads/custom-images/theme_online_features_icon_1.png',
                            'image_two'   => 'uploads/custom-images/theme_online_features_icon_2.png',
                            'image_three' => 'uploads/custom-images/theme_online_features_icon_3.png',
                            'image_four'  => 'uploads/custom-images/theme_online_features_icon_4.png',
                        ],
                    ],
                    [
                        'name'           => 'banner_section',
                        'global_content' => [
                            'instructor_image' => 'uploads/custom-images/theme_online_instructor_image.png',
                            'student_image'    => 'uploads/custom-images/theme_online_student_image.png',
                        ],
                    ],

                ],
            ],
            [
                'slug'     => ThemeList::UNIVERSITY->value,
                'sections' => [
                    [
                        'name'           => 'hero_section',
                        'global_content' => [
                            'action_button_url'     => '/courses',
                            'banner_image'          => 'uploads/custom-images/theme_university_banner_img.png',
                            'banner_background'     => 'uploads/custom-images/theme_university_banner_bg.svg',
                            'hero_background'       => 'uploads/custom-images/theme_university_hero_bg.jpg',
                            'enroll_students_image' => 'uploads/custom-images/theme_university_enroll_students_image.png',
                        ],
                    ],
                    [
                        'name'           => 'about_section',
                        'global_content' => [
                            'button_url'      => '/about-us',
                            'video_url'       => 'https://www.youtube.com/watch?v=VkBnNxneA_A',
                            'year_experience' => '15',
                            'image'           => 'uploads/custom-images/theme_university_about_img.jpg',
                        ],
                    ],
                    [
                        'name'           => 'newsletter_section',
                        'global_content' => [
                            'image' => 'uploads/custom-images/theme_university_newsletter.png',
                        ],
                    ],
                    [
                        'name'           => 'counter_section',
                        'global_content' => [
                            'total_student_count'    => 3000,
                            'total_instructor_count' => 100,
                            'total_courses_count'    => 800,
                            'button_url'             => '/courses',
                        ],
                    ],
                    [
                        'name'           => 'faq_section',
                        'global_content' => [
                            'image' => 'uploads/custom-images/theme_university_faq.png',
                        ],
                    ],
                    [
                        'name'           => 'our_features_section',
                        'global_content' => [
                            'image_one'   => 'uploads/custom-images/theme_university_features_icon_1.svg',
                            'image_two'   => 'uploads/custom-images/theme_university_features_icon_2.svg',
                            'image_three' => 'uploads/custom-images/theme_university_features_icon_3.svg',
                            'image_four'  => 'uploads/custom-images/theme_university_features_icon_4.svg',
                        ],
                    ],
                    [
                        'name'           => 'banner_section',
                        'global_content' => [
                            'bg_image'         => 'uploads/custom-images/wsus-img-2024-06-04-11-44-52-8799.jpg',
                        ],
                    ],

                ],
            ],
            [
                'slug'     => ThemeList::BUSINESS->value,
                'sections' => [
                    [
                        'name'           => 'slider_section',
                        'global_content' => [
                            'image_one'   => 'uploads/custom-images/theme_business_slider_1.jpg',
                            'image_two'   => 'uploads/custom-images/theme_business_slider_2.jpg',
                            'image_three' => 'uploads/custom-images/theme_business_slider_3.jpg',
                        ],
                    ],
                    [
                        'name'           => 'about_section',
                        'global_content' => [
                            'button_url'  => '/about-us',
                            'video_url'   => 'https://www.youtube.com/watch?v=VkBnNxneA_A',
                            'image'       => 'uploads/custom-images/theme_business_about_img.jpg',
                            'image_two'   => 'uploads/custom-images/wsus-img-2024-06-03-07-17-53-5555.jpg',
                            'image_three' => 'uploads/custom-images/wsus-img-2024-06-03-07-17-53-6666.jpg',
                        ],
                    ],
                    [
                        'name'           => 'newsletter_section',
                        'global_content' => [
                            'image' => 'uploads/custom-images/theme_business_newsletter.png',
                        ],
                    ],
                    [
                        'name'           => 'our_features_section',
                        'global_content' => [
                            'image_one'   => 'uploads/custom-images/theme_business_features_icon_1.png',
                            'image_two'   => 'uploads/custom-images/theme_business_features_icon_2.png',
                            'image_three' => 'uploads/custom-images/theme_business_features_icon_3.png',
                            'image_four'  => 'uploads/custom-images/theme_business_features_icon_4.png',
                        ],
                    ],
                    [
                        'name'           => 'banner_section',
                        'global_content' => [
                            'student_image'    => 'uploads/custom-images/theme_business_student_image.png',
                        ],
                    ],
                    [
                        'name'           => 'faq_section',
                        'global_content' => [
                            'image' => 'uploads/custom-images/theme_business_faq.png',
                        ],
                    ],
                ],
            ],
            [
                'slug'     => ThemeList::YOGA->value,
                'sections' => [
                    [
                        'name'           => 'hero_section',
                        'global_content' => [
                            'action_button_url'     => '/courses',
                            'booking_number'      => '+1 (123) 909090',
                            'banner_image'          => 'uploads/custom-images/h4_hero_img.png',
                            'banner_background'     => 'uploads/custom-images/h4_hero_img_shape02.svg',
                            'banner_background_two'     => 'uploads/custom-images/h4_hero_img_shape01.svg',
                            'hero_background'       => 'uploads/custom-images/h4_hero_bg.jpg',
                            'enroll_students_image' => 'uploads/custom-images/theme_yoga_enroll_students_image.png',
                        ],
                    ],
                    [
                        'name'           => 'our_features_section',
                        'global_content' => [
                            'image_one'   => 'uploads/custom-images/h4_features_icon01.svg',
                            'image_two'   => 'uploads/custom-images/h4_features_icon02.svg',
                            'image_three' => 'uploads/custom-images/h4_features_icon03.svg',
                            'image_four' => 'uploads/custom-images/h4_features_icon04.png',
                        ],
                    ],
                    [
                        'name'           => 'about_section',
                        'global_content' => [
                            'button_url' => '/about-us',
                            'video_url'  => 'https://www.youtube.com/watch?v=VkBnNxneA_A',
                            'image'      => 'uploads/custom-images/h4_choose_img.jpg',
                            'image_two'   => 'uploads/custom-images/h4_choose_img02.jpg',
                        ],
                    ],
                    [
                        'name'           => 'banner_section',
                        'global_content' => [
                            'student_image'    => 'uploads/custom-images/h4_cta_img.png',
                            'bg_image'    => 'uploads/custom-images/h4_video_bg.jpg',
                            'video_url'      => 'https://www.youtube.com/watch?v=pMzGDBP6Bic',
                        ],
                    ],
                    [
                        'name'           => 'newsletter_section',
                        'global_content' => [
                            'image' => 'uploads/custom-images/theme_yoga_newslettter.png',
                        ],
                    ],
                    [
                        'name'           => 'faq_section',
                        'global_content' => [
                            'image' => 'uploads/custom-images/theme_yoga_faq.png',
                        ],
                    ],
                ],
            ],
            [
                'slug'     => ThemeList::KITCHEN->value,
                'sections' => [
                    [
                        'name'           => 'hero_section',
                        'global_content' => [
                            'banner_image'          => 'uploads/custom-images/h8_hero_img.png',
                            'banner_background'     => 'uploads/custom-images/h8_hero_img_shape.svg',
                            'banner_background_two'     => 'uploads/custom-images/h8_hero_img_shape02.svg',
                            'hero_background'       => 'uploads/custom-images/h8_hero_bg.jpg',
                            'enroll_students_image' => 'uploads/custom-images/theme_kitchen_enroll_students_image.png',
                        ],
                    ],
                    [
                        'name'           => 'our_features_section',
                        'global_content' => [
                            'image_one'   => 'uploads/custom-images/theme_kitchen_features_icon_1.png',
                            'image_two'   => 'uploads/custom-images/theme_kitchen_features_icon_2.png',
                            'image_three' => 'uploads/custom-images/theme_kitchen_features_icon_3.png',
                            'image_four' => 'uploads/custom-images/theme_kitchen_features_icon_4.png',
                        ],
                    ],
                    [
                        'name'           => 'about_section',
                        'global_content' => [
                            'button_url' => '/about-us',
                            'video_url'  => 'https://www.youtube.com/watch?v=VkBnNxneA_A',
                            'image'      => 'uploads/custom-images/h8_about_img01.jpg',
                            'image_two'   => 'uploads/custom-images/h8_about_img02.jpg',
                            'image_three'   => 'uploads/custom-images/skillgro-diploma.png',
                            'course_success'   => '86',
                        ],
                    ],
                    [
                        'name'           => 'banner_section',
                        'global_content' => [
                            'student_image'    => 'uploads/custom-images/h8_cta_img.png',
                        ],
                    ],
                    [
                        'name'           => 'faq_section',
                        'global_content' => [
                            'image' => 'uploads/custom-images/theme_kitchen_faq.png',
                        ],
                    ],
                    [
                        'name'           => 'newsletter_section',
                        'global_content' => [
                            'image' => 'uploads/custom-images/theme_kitchen_newslettter.png',
                        ],
                    ],
                ],
            ],
            [
                'slug'     => ThemeList::KINDERGARTEN->value,
                'sections' => [
                    [
                        'name'           => 'hero_section',
                        'global_content' => [
                            'action_button_url' => '/courses',
                            'banner_image'      => 'uploads/custom-images/h5_hero_img.png',
                            'hero_background'   => 'uploads/custom-images/h5_hero_bg.jpg',
                        ],
                    ],
                    [
                        'name'           => 'our_features_section',
                        'global_content' => [
                            'button_url_one'   => '/about-us',
                            'image_one'        => 'uploads/custom-images/theme_kindergarten_features_icon_1.png',
                            'button_url_two'   => '/about-us',
                            'image_two'        => 'uploads/custom-images/theme_kindergarten_features_icon_2.png',
                            'button_url_three' => '/about-us',
                            'image_three'      => 'uploads/custom-images/theme_kindergarten_features_icon_3.png',
                            'button_url_four'  => '/about-us',
                            'image_four'       => 'uploads/custom-images/theme_kindergarten_features_icon_4.png',
                        ],
                    ],
                    [
                        'name'           => 'about_section',
                        'global_content' => [
                            'phone_number' => '+985 0059 500',
                            'button_url'   => '/about-us',
                            'video_url'    => 'https://www.youtube.com/watch?v=VkBnNxneA_A',
                            'image'        => 'uploads/custom-images/h5_about_img01.jpg',
                            'image_two'    => 'uploads/custom-images/h5_about_img02.jpg',
                        ],
                    ],
                    [
                        'name'           => 'faq_section',
                        'global_content' => [
                            'image' => 'uploads/custom-images/h5_faq_img.jpg',
                        ],
                    ],
                    [
                        'name'           => 'newsletter_section',
                        'global_content' => [
                            'image' => 'uploads/custom-images/theme_kindergarten_newsletter.png',
                        ],
                    ],
                    [
                        'name'           => 'banner_section',
                        'global_content' => [
                            'student_image' => 'uploads/custom-images/theme_kindergarten_student_image.png',
                        ],
                    ],
                ]
            ],
            [
                'slug'     => ThemeList::LANGUAGE->value,
                'sections' => [
                    [
                        'name'           => 'hero_section',
                        'global_content' => [
                            'action_button_url' => '/courses',
                            'video_button_url'      => 'https://www.youtube.com/watch?v=pMzGDBP6Bic',
                            'banner_image'      => 'uploads/custom-images/h6_hero_img.jpg',
                            'hero_background'   => 'uploads/custom-images/h6_hero_bg.jpg',
                            'enroll_students_image' => 'uploads/custom-images/theme_language_enroll_students_image.png',
                        ],
                    ],

                    [
                        'name'           => 'about_section',
                        'global_content' => [
                            'button_url'   => '/about-us',
                            'video_url'    => 'https://www.youtube.com/watch?v=VkBnNxneA_A',
                            'image'        => 'uploads/custom-images/h6_choose_img.jpg',
                        ],
                    ],

                    [
                        'name'           => 'faq_section',
                        'global_content' => [
                            'image'     => 'uploads/custom-images/h6_faq_img01.jpg',
                            'image_two' => 'uploads/custom-images/h6_faq_img02.jpg',
                        ],
                    ],

                    [
                        'name'           => 'counter_section',
                        'global_content' => [
                            'total_student_count'    => 3000,
                            'total_instructor_count' => 100,
                            'image'    => 'uploads/custom-images/theme_language_fact_img.png',
                        ],
                    ],


                    [
                        'name'           => 'our_features_section',
                        'global_content' => [
                            'image_one'   => 'uploads/custom-images/theme_language_features_icon_1.png',
                            'image_two'   => 'uploads/custom-images/theme_language_features_icon_2.png',
                            'image_three' => 'uploads/custom-images/theme_language_features_icon_3.png',
                            'image_four' => 'uploads/custom-images/theme_language_features_icon_4.png',
                        ],
                    ],

                    [
                        'name'           => 'banner_section',
                        'global_content' => [
                            'student_image' => 'uploads/custom-images/theme_language_student_image.png',
                        ],
                    ],
                    [

                        'name'           => 'newsletter_section',
                        'global_content' => [
                            'image' => 'uploads/custom-images/theme_language_newsletter.png',
                        ],
                    ],
                ],
            ],
        ];
        foreach ($home_pages as $home) {
            $page = Home::create(['slug' => $home['slug']]);

            foreach ($home['sections'] as $section) {
                $page->sections()->create(['name' => $section['name'], 'global_content' => $section['global_content']]);
            }
        }
    }
}

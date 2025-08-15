<?php

namespace Modules\Language\app\Enums;

enum TranslationModels: string
{
    /**
     * whenever update new case also update getAll() method
     * to return all values in array
     */
    case Blog = "Modules\Blog\app\Models\BlogTranslation";
    case BlogCategory = "Modules\Blog\app\Models\BlogCategoryTranslation";
    case Testimonial = "Modules\Testimonial\app\Models\TestimonialTranslation";
    case Faq = "Modules\Faq\app\Models\FaqTranslation";
    case CourseCategory = "Modules\Course\app\Models\CourseCategoryTranslation";
    case CourseLevel = "Modules\Course\app\Models\CourseLevelTranslation";
    case FeaturedInstructorSection = "Modules\Frontend\app\Models\FeaturedInstructorTranslation";
    case Menu = "Modules\Menubuilder\app\Models\MenuTranslation";
    case MenuItem = "Modules\Menubuilder\app\Models\MenuItemTranslation";
    case CustomPage = "Modules\PageBuilder\app\Models\CustomPageTranslation";
    case InstructorRequestSetting = "Modules\InstructorRequest\app\Models\InstructorRequestSettingTranslation";
    case Section = "Modules\Frontend\app\Models\SectionTranslation";


    public static function getAll(): array
    {
        return [
            self::Blog->value,
            self::BlogCategory->value,
            self::Testimonial->value,
            self::Faq->value,
            self::CourseCategory->value,
            self::CourseLevel->value,
            self::FeaturedInstructorSection->value,
            self::Menu->value,
            self::MenuItem->value,
            self::CustomPage->value,
            self::InstructorRequestSetting->value,
            self::Section->value,
        ];
    }

    public static function igonreColumns(): array
    {
        return [
            'id',
            'lang_code',
            'created_at',
            'updated_at',
            'deleted_at',
        ];
    }
}

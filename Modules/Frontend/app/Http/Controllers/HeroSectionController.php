<?php

namespace Modules\Frontend\app\Http\Controllers;

use App\Enums\ThemeList;
use App\Enums\RedirectType;
use App\Traits\RedirectHelperTrait;
use App\Http\Controllers\Controller;
use Modules\Frontend\app\Models\Section;
use Modules\Language\app\Models\Language;
use Modules\Language\app\Enums\TranslationModels;
use Modules\Frontend\app\Models\SectionTranslation;
use Modules\Frontend\app\Traits\UpdateSectionTraits;
use Modules\Language\app\Traits\GenerateTranslationTrait;
use Modules\Frontend\app\Http\Requests\HeroSectionUpdateRequest;

class HeroSectionController extends Controller {
    use GenerateTranslationTrait, RedirectHelperTrait, UpdateSectionTraits;

    /**
     * Display a listing of the resource.
     */
    public function index() {
        checkAdminHasPermissionAndThrowException('section.management');
        $code = request('code') ?? getSessionLanguage();
        if (!Language::where('code', $code)->exists()) {
            abort(404);
        }
        if (DEFAULT_HOMEPAGE == ThemeList::BUSINESS->value) {
            abort(404);
        }
        $languages = allLanguages();
        $heroSection = Section::getByName('hero_section');

        return view('frontend::' . DEFAULT_HOMEPAGE . '.hero-section', compact('languages', 'code', 'heroSection'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(HeroSectionUpdateRequest $request) {
        checkAdminHasPermissionAndThrowException('section.management');
        $section = Section::getByName('hero_section');

        // Update global content
        $global_content = $this->updateSectionContent($section?->global_content, $request, ['action_button_url', 'video_button_url', 'booking_number'], ['banner_image', 'banner_background', 'banner_background_two', 'hero_background', 'enroll_students_image']);

        // Update translated content
        $content = $this->updateSectionContent($section?->content, $request, ['short_title', 'title', 'sub_title', 'total_student', 'total_instructor', 'total_courses','average_reviews', 'video_button_text', 'action_button_text']);

        $section->update(['global_content' => $global_content]);

        $translation = SectionTranslation::where('section_id', $section->id)->exists();

        if (!$translation) {
            $this->generateTranslations(TranslationModels::Section, $section, 'section_id', $request);
        }

        $this->updateTranslations($section, $request, $request->only('code'), ['content' => $content]);

        return $this->redirectWithMessage(RedirectType::UPDATE->value);
    }
}

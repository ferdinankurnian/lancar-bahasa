<?php

namespace Modules\Frontend\app\Http\Controllers;

use App\Enums\RedirectType;
use App\Enums\ThemeList;
use App\Http\Controllers\Controller;
use App\Traits\RedirectHelperTrait;
use Modules\Frontend\app\Http\Requests\AboutSectionUpdateRequest;
use Modules\Frontend\app\Models\Section;
use Modules\Frontend\app\Models\SectionTranslation;
use Modules\Frontend\app\Traits\UpdateSectionTraits;
use Modules\Language\app\Enums\TranslationModels;
use Modules\Language\app\Models\Language;
use Modules\Language\app\Traits\GenerateTranslationTrait;

class AboutSectionController extends Controller {
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
        $languages = allLanguages();
        $aboutSection = Section::getByName('about_section');

        return view('frontend::' . DEFAULT_HOMEPAGE . '.about-section', compact('languages', 'code', 'aboutSection'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(AboutSectionUpdateRequest $request) {
        checkAdminHasPermissionAndThrowException('section.management');
        $section = Section::getByName('about_section');

        // Update global content
        $global_content = $this->updateSectionContent($section?->global_content, $request, ['button_url', 'video_url', 'year_experience', 'course_success', 'phone_number'], ['image', 'image_two', 'image_three']);

        // Update translated content
        $content = $this->updateSectionContent($section?->content, $request, ['short_title', 'title', 'description', 'button_text']);

        $section->update(['global_content' => $global_content]);

        $translation = SectionTranslation::where('section_id', $section->id)->exists();

        if (!$translation) {
            $this->generateTranslations(TranslationModels::Section, $section, 'section_id', $request);
        }

        $this->updateTranslations($section, $request, $request->only('code'), ['content' => $content]);

        return $this->redirectWithMessage(RedirectType::UPDATE->value);
    }

}

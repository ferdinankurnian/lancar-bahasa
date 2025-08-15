<?php

namespace Modules\Frontend\app\Http\Controllers;

use App\Enums\ThemeList;
use App\Enums\RedirectType;
use Illuminate\Http\Request;
use App\Traits\RedirectHelperTrait;
use App\Http\Controllers\Controller;
use Modules\Frontend\app\Models\Section;
use Modules\Language\app\Models\Language;
use Modules\Language\app\Enums\TranslationModels;
use Modules\Frontend\app\Models\SectionTranslation;
use Modules\Frontend\app\Traits\UpdateSectionTraits;
use Modules\Language\app\Traits\GenerateTranslationTrait;
use Modules\Frontend\app\Http\Requests\SliderSectionUpdateRequest;

class SliderSectionController extends Controller {
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
        if (DEFAULT_HOMEPAGE != ThemeList::BUSINESS->value) {
            abort(404);
        }
        $languages = allLanguages();
        $sliderSection = Section::getByName('slider_section');

        return view('frontend::' . DEFAULT_HOMEPAGE . '.slider-section', compact('languages', 'code', 'sliderSection'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SliderSectionUpdateRequest $request) {
        checkAdminHasPermissionAndThrowException('section.management');
        $section = Section::getByName('slider_section');

        // Update global content
        $global_content = $this->updateSectionContent($section?->global_content, $request, [], ['image_one', 'image_two', 'image_three']);

        // Update translated content
        $content = $this->updateSectionContent($section?->content, $request, ['short_title_one','title_one', 'sub_title_one', 'short_title_two','title_two', 'sub_title_two', 'short_title_three','title_three', 'sub_title_three']);

        $section->update(['global_content' => $global_content]);

        $translation = SectionTranslation::where('section_id', $section->id)->exists();

        if (!$translation) {
            $this->generateTranslations(TranslationModels::Section, $section, 'section_id', $request);
        }

        $this->updateTranslations($section, $request, $request->only('code'), ['content' => $content]);

        return $this->redirectWithMessage(RedirectType::UPDATE->value);
    }
}

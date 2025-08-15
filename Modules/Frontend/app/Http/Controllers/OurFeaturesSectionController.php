<?php

namespace Modules\Frontend\app\Http\Controllers;

use App\Enums\RedirectType;
use App\Http\Controllers\Controller;
use App\Traits\RedirectHelperTrait;
use Modules\Frontend\app\Http\Requests\OurFeaturesSectionUpdateRequest;
use Modules\Frontend\app\Models\Section;
use Modules\Frontend\app\Models\SectionTranslation;
use Modules\Frontend\app\Traits\UpdateSectionTraits;
use Modules\Language\app\Enums\TranslationModels;
use Modules\Language\app\Models\Language;
use Modules\Language\app\Traits\GenerateTranslationTrait;

class OurFeaturesSectionController extends Controller {
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
        $ourFeature = Section::getByName('our_features_section');

        return view('frontend::' . DEFAULT_HOMEPAGE . '.our-features-section', compact('languages', 'code', 'ourFeature'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(OurFeaturesSectionUpdateRequest $request) {
        checkAdminHasPermissionAndThrowException('section.management');
        $section = Section::getByName('our_features_section');

        // Update global content
        $global_content = $this->updateSectionContent($section?->global_content, $request, ['button_url_one','button_url_two' ,'button_url_three','button_url_four'], ['image_one', 'image_two', 'image_three', 'image_four']);

        // Update translated content
        $content = $this->updateSectionContent($section?->content, $request, ['sec_title','sec_description','title_one', 'sub_title_one', 'title_two', 'sub_title_two', 'title_three', 'sub_title_three', 'title_four', 'sub_title_four']);

        $section->update(['global_content' => $global_content]);

        $translation = SectionTranslation::where('section_id', $section->id)->exists();

        if (!$translation) {
            $this->generateTranslations(TranslationModels::Section, $section, 'section_id', $request);
        }

        $this->updateTranslations($section, $request, $request->only('code'), ['content' => $content]);

        return $this->redirectWithMessage(RedirectType::UPDATE->value);
    }
}

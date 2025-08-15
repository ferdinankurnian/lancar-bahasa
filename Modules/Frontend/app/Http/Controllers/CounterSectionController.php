<?php

namespace Modules\Frontend\app\Http\Controllers;

use App\Enums\RedirectType;
use App\Enums\ThemeList;
use App\Http\Controllers\Controller;
use App\Traits\RedirectHelperTrait;
use Modules\Frontend\app\Http\Requests\CounterSectionRequest;
use Modules\Frontend\app\Models\Section;
use Modules\Frontend\app\Models\SectionTranslation;
use Modules\Frontend\app\Traits\UpdateSectionTraits;
use Modules\Language\app\Enums\TranslationModels;
use Modules\Language\app\Models\Language;
use Modules\Language\app\Traits\GenerateTranslationTrait;

class CounterSectionController extends Controller {
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
        if(!in_array(DEFAULT_HOMEPAGE,[ThemeList::MAIN->value, ThemeList::ONLINE->value, ThemeList::UNIVERSITY->value, ThemeList::LANGUAGE->value])){
            abort(404);
        }
        $languages = allLanguages();
        $counter = Section::getByName('counter_section');

        return view('frontend::' . DEFAULT_HOMEPAGE . '.counter-section', compact('languages', 'code', 'counter'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CounterSectionRequest $request) {
        checkAdminHasPermissionAndThrowException('section.management');
        $section = Section::getByName('counter_section');

        // Update global content
        $global_content = $this->updateSectionContent($section?->global_content, $request, ['total_student_count', 'total_instructor_count', 'total_courses_count', 'total_awards_count', 'button_url'],['image']);

        $section->update(['global_content' => $global_content]);

        if (DEFAULT_HOMEPAGE != ThemeList::MAIN->value) {
            // Update translated content
            $content = $this->updateSectionContent($section?->content, $request, ['title', 'description', 'button_text']);
            $translation = SectionTranslation::where('section_id', $section->id)->exists();

            if (!$translation && DEFAULT_HOMEPAGE != ThemeList::BUSINESS->value) {
                $this->generateTranslations(TranslationModels::Section, $section, 'section_id', $request);
            }

            $this->updateTranslations($section, $request, $request->only('code'), ['content' => $content]);
        }

        return $this->redirectWithMessage(RedirectType::UPDATE->value);
    }

}

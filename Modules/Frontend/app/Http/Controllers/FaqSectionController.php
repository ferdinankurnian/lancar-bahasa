<?php

namespace Modules\Frontend\app\Http\Controllers;

use App\Enums\RedirectType;
use App\Http\Controllers\Controller;
use App\Traits\RedirectHelperTrait;
use Illuminate\Http\Request;
use Modules\Frontend\app\Models\Section;
use Modules\Frontend\app\Models\SectionTranslation;
use Modules\Frontend\app\Traits\UpdateSectionTraits;
use Modules\Language\app\Enums\TranslationModels;
use Modules\Language\app\Models\Language;
use Modules\Language\app\Traits\GenerateTranslationTrait;

class FaqSectionController extends Controller {
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
        $faqSection = Section::getByName('faq_section');

        return view('frontend::' . DEFAULT_HOMEPAGE . '.faq-section', compact('languages', 'code', 'faqSection'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request) {
        checkAdminHasPermissionAndThrowException('section.management');
        $request->validate([
            'short_title'     => ['required', 'string', 'max:255'],
            'title'           => ['required', 'string', 'max:255'],
            'description'     => ['required', 'string', 'max:1000'],
            'total_languages' => ['nullable', 'string', 'max:255'],
            'image'           => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'image_two'       => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], [
            'short_title.required' => __('The short title is required'),
            'short_title.string'   => __('The short title must be a string'),
            'short_title.max'      => __('The short title must not be more than 255 characters'),
            'title.required'       => __('The title is required'),
            'title.string'         => __('The title must be a string'),
            'title.max'            => __('The title must not be more than 255 characters'),
            'description.required' => __('Description is required.'),
            'description.string'   => __('The description is not valid.'),
            'description.max'      => __('The description is too long.'),
            'image.image'          => __('The image is not valid.'),
            'image.max'            => __('The image is too large.'),
            'image_two.image'      => __('The image two must be an image.'),
            'image_two.max'        => __('The image two may not be greater than 2048 kilobytes.'),
        ]);
        $section = Section::getByName('faq_section');

        // Update global content
        $global_content = $this->updateSectionContent($section?->global_content, $request, [], ['image', 'image_two']);

        // Update translated content
        $content = $this->updateSectionContent($section?->content, $request, ['short_title', 'title', 'description', 'total_languages']);

        $section->update(['global_content' => $global_content]);

        $translation = SectionTranslation::where('section_id', $section->id)->exists();

        if (!$translation) {
            $this->generateTranslations(TranslationModels::Section, $section, 'section_id', $request);
        }

        $this->updateTranslations($section, $request, $request->only('code'), ['content' => $content]);

        return $this->redirectWithMessage(RedirectType::UPDATE->value);
    }
}

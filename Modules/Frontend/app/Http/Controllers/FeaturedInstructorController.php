<?php

namespace Modules\Frontend\app\Http\Controllers;

use App\Enums\RedirectType;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\RedirectHelperTrait;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\Frontend\app\Http\Requests\FeaturedInstructorSectionUpdateRequest;
use Modules\Frontend\app\Models\FeaturedInstructor;
use Modules\Frontend\app\Models\FeaturedInstructorTranslation;
use Modules\Language\app\Enums\TranslationModels;
use Modules\Language\app\Models\Language;
use Modules\Language\app\Traits\GenerateTranslationTrait;

class FeaturedInstructorController extends Controller {
    use GenerateTranslationTrait, RedirectHelperTrait;

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id) {

        checkAdminHasPermissionAndThrowException('section.management');

        $code = request('code') ?? getSessionLanguage();
        if (!Language::where('code', $code)->exists()) {
            abort(404);
        }
        $languages = allLanguages();
        $featured = FeaturedInstructor::first();
        $instructors = User::where(['role' => 'instructor', 'status' => 'active', 'is_banned' => 'no'])->get();
        return view('frontend::featured-instructor-section', compact('languages', 'code', 'featured', 'instructors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FeaturedInstructorSectionUpdateRequest $request, $id): RedirectResponse {
        checkAdminHasPermissionAndThrowException('section.management');

        $featured = FeaturedInstructor::updateOrCreate(
            ['id' => 1],
            [
                'button_url'     => $request->button_url,
                'instructor_ids' => json_encode($request->instructor_ids),
            ]
        );

        $translation = FeaturedInstructorTranslation::where('featured_instructor_section_id', $featured->id)->exists();

        if (!$translation) {
            $this->generateTranslations(
                TranslationModels::FeaturedInstructorSection,
                $featured,
                'featured_instructor_section_id',
                $request,
            );
        }

        $this->updateTranslations(
            $featured,
            $request,
            $request->all(),
        );

        return $this->redirectWithMessage(
            RedirectType::UPDATE->value,
            'admin.featured-instructor-section.edit',
            [
                'featured_instructor_section' => $featured->id,
                'code'                        => allLanguages()->first()->code,
            ]
        );
    }

}

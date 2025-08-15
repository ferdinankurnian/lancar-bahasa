<?php

namespace Modules\InstructorRequest\app\Http\Controllers;

use App\Enums\RedirectType;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Traits\RedirectHelperTrait;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Modules\Language\app\Models\Language;
use Modules\Language\app\Enums\TranslationModels;
use Modules\Language\app\Traits\GenerateTranslationTrait;
use Modules\InstructorRequest\app\Models\InstructorRequestSetting;
use Modules\InstructorRequest\app\Models\InstructorRequestSettingTranslation;

class InstructorRequestSettingController extends Controller
{
    use GenerateTranslationTrait, RedirectHelperTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        checkAdminHasPermissionAndThrowException('instructor.request.setting');
        $code = request('code') ?? getSessionLanguage();
        if (!Language::where('code', $code)->exists()) {
            abort(404);
        }
        $languages = allLanguages();

        $instructorRequestSetting = InstructorRequestSetting::first();
        return view('instructorrequest::instructor-request-setting.index', compact('languages', 'code','instructorRequestSetting'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        checkAdminHasPermissionAndThrowException('instructor.request.setting');

        InstructorRequestSetting::updateOrCreate(['id' => $id],
            [
                'need_certificate' => $request->need_certificate,
                'need_identity_scan' => $request->need_identity_scan,
                'bank_information' => $request->bank_information
            ]
        );

        $instructorRequestSetting = InstructorRequestSetting::updateOrCreate(
            ['id' => 1],
            [
                'need_certificate' => $request->need_certificate,
                'need_identity_scan' => $request->need_identity_scan,
                'bank_information' => $request->bank_information
            ]
        );

        $translation = InstructorRequestSettingTranslation::where('instructor_request_setting_id', $instructorRequestSetting->id)->exists();

        if (!$translation) {
            $this->generateTranslations(
                TranslationModels::InstructorRequestSetting,
                $instructorRequestSetting,
                'instructor_request_setting_id',
                $request,
            );
        }

        $this->updateTranslations(
            $instructorRequestSetting,
            $request,
            $request->all(),
        );

        return redirect()->back()->with(['messege' => __('Updated successfully'), 'alert-type' => 'success']);
    }
}

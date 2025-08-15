<?php

namespace Modules\SiteAppearance\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\SiteAppearance\app\Models\SectionSetting;

class SectionSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        checkAdminHasPermissionAndThrowException('appearance.management');
        $sectionSetting = SectionSetting::first();
        return view('siteappearance::section-setting.index', compact('sectionSetting'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) 
    {
        checkAdminHasPermissionAndThrowException('appearance.management');

        SectionSetting::updateOrCreate(
            ['id' => 1],
            [
                'hero_section' => $request->has('hero_section'),
                'top_category_section' => $request->has('top_category_section'),
                'brands_section' => $request->has('brands_section'),
                'about_section' => $request->has('about_section'),
                'featured_course_section' => $request->has('featured_course_section'),
                'news_letter_section' => $request->has('news_letter_section'),
                'featured_instructor_section' => $request->has('featured_instructor_section'),
                'counter_section' => $request->has('counter_section'),
                'faq_section' => $request->has('faq_section'),
                'our_features_section' => $request->has('our_features_section'),
                'testimonial_section' => $request->has('testimonial_section'),
                'banner_section' => $request->has('banner_section'),
                'latest_blog_section' => $request->has('latest_blog_section'),
                'blog_page' => $request->has('blog_page'),
                'about_page' => $request->has('about_page'),
                'contact_page' => $request->has('contact_page'),
            ]
        );
        return redirect()->back()->with(['messege' => __('Updated successfully'), 'alert-type' => 'success']);
    }
}

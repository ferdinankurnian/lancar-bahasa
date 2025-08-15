<?php

namespace Modules\Frontend\app\Http\Controllers;

use App\Enums\RedirectType;
use Illuminate\Http\Request;
use App\Traits\RedirectHelperTrait;
use App\Http\Controllers\Controller;
use Modules\Frontend\app\Models\Section;
use Modules\Frontend\app\Traits\UpdateSectionTraits;

class BannerSectionController extends Controller {
    use RedirectHelperTrait, UpdateSectionTraits;
    /**
     * Display a listing of the resource.
     */
    public function index() {
        checkAdminHasPermissionAndThrowException('section.management');
        $bannerSection = Section::getByName('banner_section');
        return view('frontend::' . DEFAULT_HOMEPAGE . '.banner-section', compact('bannerSection'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request) {
        checkAdminHasPermissionAndThrowException('section.management');
        $request->validate([
            'instructor_image' => ['nullable', 'image', 'max:2048'],
            'student_image'    => ['nullable', 'image', 'max:2048'],
            'bg_image'         => ['nullable', 'image', 'max:2048'],
            'video_url' => ['nullable', 'max: 255'],
        ], [
            'instructor_image.nullable' => __('The image is required.'),
            'instructor_image.image'    => __('The image must be an image file.'),
            'instructor_image.max'      => __('The image may not be greater than 2048 kilobytes.'),
            'student_image.nullable'    => __('The image is required.'),
            'student_image.image'       => __('The image must be an image file.'),
            'student_image.max'         => __('The image may not be greater than 2048 kilobytes.'),
            'bg_image.nullable'         => __('The image is required.'),
            'bg_image.image'            => __('The image must be an image file.'),
            'bg_image.max'              => __('The image may not be greater than 2048 kilobytes.'),
            'video_url.nullable' => __('The video url is not valid.'),
            'video_url.max' => __('The video url is too long.'),
        ]);
        $section = Section::getByName('banner_section');
        // Update global content
        $global_content = $this->updateSectionContent($section?->global_content, $request, ['video_url'], ['instructor_image', 'student_image','bg_image']);

        $section->update(['global_content' => $global_content]);

        return $this->redirectWithMessage(RedirectType::UPDATE->value);
    }
}

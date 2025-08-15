<?php

namespace Modules\Frontend\app\Http\Controllers;

use App\Enums\RedirectType;
use App\Http\Controllers\Controller;
use App\Traits\RedirectHelperTrait;
use Illuminate\Http\Request;
use Modules\Frontend\app\Models\Section;
use Modules\Frontend\app\Traits\UpdateSectionTraits;

class NewsLetterSectionController extends Controller {
    use RedirectHelperTrait, UpdateSectionTraits;
    /**
     * Display a listing of the resource.
     */
    public function index() {
        checkAdminHasPermissionAndThrowException('section.management');
        $newsletter = Section::getByName('newsletter_section');

        return view('frontend::' . DEFAULT_HOMEPAGE . '.newsletter-section', compact('newsletter'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request) {
        checkAdminHasPermissionAndThrowException('section.management');
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], [
            'image.required' => __('The image is required.'),
            'image.image'    => __('The image is not valid.'),
            'image.max'      => __('The image is too large.'),
        ]);
        $section = Section::getByName('newsletter_section');

        // Update global content
        $global_content = $this->updateSectionContent($section?->global_content, $request, [], ['image']);

        $section->update(['global_content' => $global_content]);

        return $this->redirectWithMessage(RedirectType::UPDATE->value);
    }
}

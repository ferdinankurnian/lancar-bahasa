<?php

namespace Modules\PageBuilder\app\Http\Controllers;

use App\Enums\RedirectType;
use App\Http\Controllers\Controller;
use App\Traits\RedirectHelperTrait;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Language\app\Enums\TranslationModels;
use Modules\Language\app\Models\Language;
use Modules\Language\app\Traits\GenerateTranslationTrait;
use Modules\PageBuilder\app\Models\CustomPage;

class PageBuilderController extends Controller
{
    use GenerateTranslationTrait, RedirectHelperTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        checkAdminHasPermissionAndThrowException('page.management');
        $pages = CustomPage::all();
        return view('pagebuilder::index', compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pagebuilder::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) 
    {
        checkAdminHasPermissionAndThrowException('page.management');
        $validated = $request->validate([
            'name' => ['required'],
            'slug' => ['required', 'string', 'max:255', 'unique:custom_pages,slug'],
            'content' => ['required'],
            'status' => ['required'],
        ], [
            'name.required' => __('The name field is required.'),
            'slug.required' => __('The slug field is required.'),
            'content.required' => __('The content field is required.'),

        ]);

        $pageBuilder = CustomPage::create($validated);

        $languages = allLanguages();

        $this->generateTranslations(
            TranslationModels::CustomPage,
            $pageBuilder,
            'custom_page_id',
            $request,
        );

        return $this->redirectWithMessage(RedirectType::CREATE->value, 'admin.page-builder.edit', ['page_builder' => $pageBuilder->id, 'code' => $languages->first()->code]);
       
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('pagebuilder::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        checkAdminHasPermissionAndThrowException('page.management');

        $code = request('code') ?? getSessionLanguage();

        abort_unless(Language::where('code', $code)->exists(), 404);

        $page = CustomPage::with('translation')->findOrFail($id);
        $languages = allLanguages();

        return view('pagebuilder::edit', compact('page', 'code', 'languages'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        checkAdminHasPermissionAndThrowException('page.management');

        $validated = $request->validate([
            'name' => ['required'],
            'slug' => ['required', 'string', 'max:255', 'unique:custom_pages,slug, '.$id],
            'content' => ['required'],
            'status' => ['required'],
        ], [
            'name.required' => __('The name field is required.'),
            'slug.required' => __('The slug field is required.'),
            'content.required' => __('The content field is required.'),

        ]);

        $page = CustomPage::findOrFail($id);
        $page->update($validated);

        $this->updateTranslations(
            $page,
            $request,
            $validated,
        );

        return $this->redirectWithMessage(RedirectType::UPDATE->value, 'admin.page-builder.edit', ['page_builder' => $page->id, 'code' => $request->code]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        checkAdminHasPermissionAndThrowException('page.management');

        $page = CustomPage::findOrFail($id);
        $page->delete();

        return $this->redirectWithMessage(RedirectType::DELETE->value, 'admin.page-builder.index');
        
    }

    public function statusUpdate($id)
    {
        checkAdminHasPermissionAndThrowException('page.management');

        $page = CustomPage::find($id);
        $status = $page->status == 1 ? 0 : 1;
        $page->update(['status' => $status]);

        $notification = __('Updated Successfully');

        return response()->json([
            'success' => true,
            'message' => $notification,
        ]);
    }
}

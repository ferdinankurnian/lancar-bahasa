<?php

namespace Modules\Faq\app\Http\Controllers;

use App\Enums\RedirectType;
use App\Http\Controllers\Controller;
use App\Traits\RedirectHelperTrait;
use Illuminate\Pagination\Paginator;
use Modules\Faq\app\Http\Requests\FaqRequest;
use Modules\Faq\app\Models\Faq;
use Modules\Language\app\Enums\TranslationModels;
use Modules\Language\app\Models\Language;
use Modules\Language\app\Traits\GenerateTranslationTrait;

class FaqController extends Controller
{
    use GenerateTranslationTrait, RedirectHelperTrait;

    public function index()
    {
        checkAdminHasPermissionAndThrowException('faq.view');
        Paginator::useBootstrap();
        $faqs = Faq::with('translation')->paginate(15);

        return view('faq::index', compact('faqs'));
    }

    public function create()
    {
        checkAdminHasPermissionAndThrowException('faq.create');

        return view('faq::create');
    }

    public function store(FaqRequest $request)
    {
        checkAdminHasPermissionAndThrowException('faq.store');

        $faq = Faq::create($request->validated());

        $languages = allLanguages();

        $this->generateTranslations(
            TranslationModels::Faq,
            $faq,
            'faq_id',
            $request,
        );

        return $this->redirectWithMessage(RedirectType::CREATE->value, 'admin.faq.edit', ['faq' => $faq->id, 'code' => $languages->first()->code]);
    }

    public function show($id)
    {
        checkAdminHasPermissionAndThrowException('faq.view');

        return view('faq::show');
    }

    public function edit($id)
    {
        checkAdminHasPermissionAndThrowException('faq.edit');

        $code = request('code') ?? getSessionLanguage();

        abort_unless(Language::where('code', $code)->exists(), 404);

        $faq = Faq::with('translation')->findOrFail($id);
        $languages = allLanguages();

        return view('faq::edit', compact('faq', 'code', 'languages'));
    }

    public function update(FaqRequest $request, $id)
    {
        checkAdminHasPermissionAndThrowException('faq.update');

        $faq = Faq::findOrFail($id);

        $validatedData = $request->validated();

        $faq->update($validatedData);

        $this->updateTranslations(
            $faq,
            $request,
            $validatedData,
        );

        return $this->redirectWithMessage(RedirectType::UPDATE->value, 'admin.faq.edit', ['faq' => $faq->id, 'code' => $request->code]);
    }

    public function destroy($id)
    {
        checkAdminHasPermissionAndThrowException('faq.delete');

        $faq = Faq::findOrFail($id);

        $faq->translations()->each(function ($translation) {
            $translation->faq()->dissociate();
            $translation->delete();
        });

        $faq->delete();

        return $this->redirectWithMessage(RedirectType::DELETE->value, 'admin.faq.index');
    }

    public function statusUpdate($id)
    {
        checkAdminHasPermissionAndThrowException('faq.update');

        $faq = Faq::find($id);
        $status = $faq->status == 1 ? 0 : 1;
        $faq->update(['status' => $status]);

        $notification = __('Updated Successfully');

        return response()->json([
            'success' => true,
            'message' => $notification,
        ]);
    }
}

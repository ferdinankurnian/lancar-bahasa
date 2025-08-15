<?php

namespace Modules\Testimonial\app\Http\Controllers;

use App\Enums\RedirectType;
use App\Http\Controllers\Controller;
use App\Traits\RedirectHelperTrait;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\File;
use Modules\Language\app\Enums\TranslationModels;
use Modules\Language\app\Models\Language;
use Modules\Language\app\Traits\GenerateTranslationTrait;
use Modules\Testimonial\app\Http\Requests\TestimonialRequest;
use Modules\Testimonial\app\Models\Testimonial;

class TestimonialController extends Controller
{
    use GenerateTranslationTrait, RedirectHelperTrait;

    public function index()
    {
        checkAdminHasPermissionAndThrowException('testimonial.view');
        Paginator::useBootstrap();
        $testimonials = Testimonial::with('translation')->paginate(15);

        return view('testimonial::index', compact('testimonials'));
    }

    public function create()
    {
        checkAdminHasPermissionAndThrowException('testimonial.create');

        return view('testimonial::create');
    }

    public function store(TestimonialRequest $request)
    {
        checkAdminHasPermissionAndThrowException('testimonial.store');

        $testimonial = Testimonial::create($request->validated());

        if ($testimonial && $request->hasFile('image')) {
            $file_name = file_upload($request->image, 'uploads/custom-images/', $testimonial->image);
            $testimonial->image = $file_name;
            $testimonial->save();
        }

        $languages = allLanguages();

        $this->generateTranslations(
            TranslationModels::Testimonial,
            $testimonial,
            'testimonial_id',
            $request,
        );

        return $this->redirectWithMessage(RedirectType::CREATE->value, 'admin.testimonial.edit', ['testimonial' => $testimonial->id, 'code' => $languages->first()->code]);
    }

    public function show($id)
    {
        checkAdminHasPermissionAndThrowException('testimonial.view');

        return view('testimonial::show');
    }

    public function edit($id)
    {
        checkAdminHasPermissionAndThrowException('testimonial.edit');
        $code = request('code') ?? getSessionLanguage();
        abort_unless(Language::where('code', $code)->exists(), 404);

        $testimonial = Testimonial::findOrFail($id);
        $languages = allLanguages();

        return view('testimonial::edit', compact('testimonial', 'code', 'languages'));
    }

    public function update(TestimonialRequest $request, $id)
    {
        checkAdminHasPermissionAndThrowException('testimonial.update');

        $testimonial = Testimonial::findOrFail($id);

        $validatedData = $request->validated();

        $testimonial->update($validatedData);

        if ($testimonial && $request->hasFile('image')) {
            $file_name = file_upload($request->image, 'uploads/custom-images/', $testimonial->image);
            $testimonial->image = $file_name;
            $testimonial->save();
        }

        $this->updateTranslations(
            $testimonial,
            $request,
            $validatedData,
        );

        return $this->redirectWithMessage(RedirectType::UPDATE->value, 'admin.testimonial.edit', ['testimonial' => $testimonial->id, 'code' => $request->code]);
    }

    public function destroy($id)
    {
        checkAdminHasPermissionAndThrowException('testimonial.delete');

        $testimonial = Testimonial::findOrFail($id);
        $testimonial->translations()->each(function ($translation) {
            $translation->testimonial()->dissociate();
            $translation->delete();
        });

        if ($testimonial->image) {
            if (File::exists(public_path($testimonial->image))) {
                @unlink(public_path($testimonial->image));
            }
        }
        $testimonial->delete();

        return $this->redirectWithMessage(RedirectType::DELETE->value, 'admin.testimonial.index');
    }

    public function statusUpdate($id)
    {
        checkAdminHasPermissionAndThrowException('testimonial.update');
        $testimonial = Testimonial::find($id);
        $status = $testimonial->status == 1 ? 0 : 1;
        $testimonial->update(['status' => $status]);

        $notification = __('Updated Successfully');

        return response()->json([
            'success' => true,
            'message' => $notification,
        ]);
    }
}

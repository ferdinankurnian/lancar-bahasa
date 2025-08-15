<?php

namespace Modules\Course\app\Http\Controllers;

use App\Enums\RedirectType;
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Traits\RedirectHelperTrait;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Course\app\Http\Requests\CourseCategoryStoreRequest;
use Modules\Course\app\Http\Requests\CourseSubCategoryRequest;
use Modules\Course\app\Models\CourseCategory;
use Modules\Language\app\Enums\TranslationModels;
use Modules\Language\app\Models\Language;
use Modules\Language\app\Traits\GenerateTranslationTrait;

class CourseSubCategoryController extends Controller
{
    use GenerateTranslationTrait, RedirectHelperTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = CourseCategory::query();
        $query->when($request->keyword, function($q) {
            $q->whereHas('translations', function($q) {
                $q->where('name', 'like', '%' . request('keyword') . '%');
            });
        });
        $query->where('parent_id', $request->parent_id);
        $query->when(
            $request->status !== null && $request->status !== '',
            fn($q) => $q->where('status', $request->status)
        );
        $orderBy = $request->order_by == 1 ? 'asc' : 'desc';
        $categories = $request->get('par-page') == 'all' ?
            $query->orderBy('id', $orderBy)->get() :
            $query->orderBy('id', $orderBy)->paginate($request->get('par-page') ?? null)->withQueryString();
        $parentCategory = CourseCategory::find($request->parent_id);
        return view('course::course-sub-category.index', compact('categories', 'parentCategory'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('course::course-sub-category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CourseSubCategoryRequest $request, string $parentId): RedirectResponse
    {
        $subCategory = new CourseCategory();
        $subCategory->slug = $request->slug;
        $subCategory->parent_id = $parentId;
        $subCategory->status = $request->status;
        $subCategory->save();

        $languages = Language::all();

        $this->generateTranslations(
            TranslationModels::CourseCategory,
            $subCategory,
            'course_category_id',
            $request,
        );

        return $this->redirectWithMessage(
            RedirectType::CREATE->value,
            'admin.course-sub-category.edit',
            [
                'parent_id' => $parentId,
                'sub_category_id' => $subCategory->id,
                'code' => $languages->first()->code
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $parentId, string $subCategoryId)
    {
        $code = request('code') ?? getSessionLanguage();
        if (!Language::where('code', $code)->exists()) {
            abort(404);
        }
        $subCategory = CourseCategory::findOrFail($subCategoryId);
        $languages = allLanguages();

        return view('course::course-sub-category.edit', compact('subCategory', 'code', 'languages'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CourseSubCategoryRequest $request, $parentId, $subCategoryId): RedirectResponse
    {
        $category = CourseCategory::findOrFail($subCategoryId);
        $category->status = $request->status;
        $category->save();

        $languages = Language::all();

        $this->updateTranslations(
            $category,
            $request,
            $request->validated(),
        );

        return $this->redirectWithMessage(
            RedirectType::UPDATE->value,
            'admin.course-sub-category.edit',
            [
                'parent_id' => $parentId,
                'sub_category_id' => $subCategoryId,
                'code' => $languages->first()->code
            ]
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $parentId, string $subCategoryId)
    {
        $subCategory = CourseCategory::findOrFail($subCategoryId);
        if(Course::where('category_id', $subCategoryId)->exists()){
            return redirect()->route('admin.course-category.index')->with(['messege' => 'Category can not be deleted because it has courses', 'alert-type' => 'error']);
        }
        $subCategory->translations()->delete();
        $subCategory->delete();

        return $this->redirectWithMessage(RedirectType::DELETE->value, 'admin.course-sub-category.index', ['parent_id' => $parentId]);
    }

    public function statusUpdate($id)
    {
        $subCategory = CourseCategory::find($id);
        $status = $subCategory->status == 1 ? 0 : 1;
        $subCategory->update(['status' => $status]);

        $notification = __('Updated Successfully');

        return response()->json([
            'success' => true,
            'message' => $notification,
        ]);
    }
}

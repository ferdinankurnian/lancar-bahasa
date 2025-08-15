<?php

namespace Modules\Course\app\Http\Controllers;

use App\Enums\RedirectType;
use App\Http\Controllers\Controller;
use App\Models\CourseSelectedLevel;
use App\Traits\RedirectHelperTrait;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Course\app\Http\Requests\CourseLevelRequest;
use Modules\Course\app\Models\CourseLevel;
use Modules\Language\app\Enums\TranslationModels;
use Modules\Language\app\Models\Language;
use Modules\Language\app\Traits\GenerateTranslationTrait;

class CourseLevelController extends Controller
{
    use GenerateTranslationTrait, RedirectHelperTrait;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = CourseLevel::query();
        $query->with(['translation']);
        $query->when($request->keyword, function ($q) {
            $q->whereHas('translations', function ($q) {
                $q->where('name', 'like', '%' . request('keyword') . '%');
            });
        });
        $query->when(
            $request->status !== null && $request->status !== '',
            fn ($q) => $q->where('status', $request->status)
        );
        $orderBy = $request->order_by == 1 ? 'asc' : 'desc';
        $courseLevels = $request->get('par-page') == 'all' ?
            $query->orderBy('id', $orderBy)->get() :
            $query->orderBy('id', $orderBy)->paginate($request->get('par-page') ?? null)->withQueryString();
        return view('course::course-level.index', compact('courseLevels'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('course::course-level.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CourseLevelRequest $request): RedirectResponse
    {
        $courseLevel = new CourseLevel();
        $courseLevel->slug = $request->slug;
        $courseLevel->status = $request->status;
        $courseLevel->save();

        $languages = Language::all();

        $this->generateTranslations(
            TranslationModels::CourseLevel,
            $courseLevel,
            'course_level_id',
            $request,
        );

        return $this->redirectWithMessage(RedirectType::CREATE->value, 'admin.course-level.edit', ['course_level' => $courseLevel->id, 'code' => $languages->first()->code]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $code = request('code') ?? getSessionLanguage();
        if (!Language::where('code', $code)->exists()) {
            abort(404);
        }
        $courseLevel = CourseLevel::findOrFail($id);
        $languages = allLanguages();

        return view('course::course-level.edit', compact('courseLevel', 'code', 'languages'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CourseLevelRequest $request, $id): RedirectResponse
    {
        $courseLevel = CourseLevel::findOrFail($id);
        $courseLevel->status = $request->status;
        $courseLevel->save();

        $languages = Language::all();

        $this->updateTranslations(
            $courseLevel,
            $request,
            $request->validated(),
        );

        return $this->redirectWithMessage(RedirectType::UPDATE->value, 'admin.course-level.edit', ['course_level' => $courseLevel->id, 'code' => $languages->first()->code]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if(CourseSelectedLevel::where('level_id', $id)->exists()) {
           return redirect()->back()->with(['alert-type' => 'error', 'messege' => __('Can not delete this level because it being used by courses')]);
             
        }
        $courseLevel = CourseLevel::findOrFail($id);
        $courseLevel->translations()->delete();
        $courseLevel->delete();

        return $this->redirectWithMessage(RedirectType::DELETE->value, 'admin.course-level.index');
    }

    public function statusUpdate($id)
    {
        $courseLevel = CourseLevel::find($id);
        $status = $courseLevel->status == 1 ? 0 : 1;
        $courseLevel->update(['status' => $status]);

        $notification = __('Updated Successfully');

        return response()->json([
            'success' => true,
            'message' => $notification,
        ]);
    }
}

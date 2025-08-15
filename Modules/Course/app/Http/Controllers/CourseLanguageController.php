<?php

namespace Modules\Course\app\Http\Controllers;

use App\Enums\RedirectType;
use App\Http\Controllers\Controller;
use App\Models\CourseSelectedLanguage;
use App\Traits\RedirectHelperTrait;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Course\app\Http\Requests\CourseLanguageRequest;
use Modules\Course\app\Models\CourseLanguage;

class CourseLanguageController extends Controller
{
    use RedirectHelperTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = CourseLanguage::query();
        $query->when($request->keyword, fn ($q) => $q->where('name', 'like', '%' . request('keyword') . '%'));
        $query->when(
            $request->status !== null && $request->status !== '',
            fn ($q) => $q->where('status', $request->status)
        );
        $orderBy = $request->order_by == 1 ? 'asc' : 'desc';
        $courseLanguages = $request->get('par-page') == 'all' ?
            $query->orderBy('id', $orderBy)->get() :
            $query->orderBy('id', $orderBy)->paginate($request->get('par-page') ?? null)->withQueryString();
        return view('course::course-language.index', compact('courseLanguages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('course::course-language.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CourseLanguageRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = file_upload($request->file('image'), 'uploads/flags/');
        }

        $courseLanguage = new CourseLanguage();
        $courseLanguage->fill($data);
        $courseLanguage->save();

        return $this->redirectWithMessage(RedirectType::CREATE->value, 'admin.course-language.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $courseLanguage = CourseLanguage::find($id);
        return view('course::course-language.edit', compact('courseLanguage'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CourseLanguageRequest $request, $id): RedirectResponse
    {
        $courseLanguage = CourseLanguage::findOrFail($id);
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = file_upload($request->file('image'), 'uploads/flags/', $courseLanguage->image);
        }

        $courseLanguage->fill($data);
        $courseLanguage->save();

        return $this->redirectWithMessage(RedirectType::UPDATE->value, 'admin.course-language.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if(CourseSelectedLanguage::where('language_id', $id)->exists()) {
            return redirect()->back()->with(['messege' => 'Selected language can not be deleted it being used in courses', 'alert-type' => 'error']);
            
        }
        $courseLanguage = CourseLanguage::find($id);
        $courseLanguage->delete();

        return $this->redirectWithMessage(RedirectType::DELETE->value, 'admin.course-language.index');
    }

    public function statusUpdate($id)
    {
        $language = CourseLanguage::find($id);
        $status = $language->status == 1 ? 0 : 1;
        $language->update(['status' => $status]);

        $notification = __('Updated Successfully');

        return response()->json([
            'success' => true,
            'message' => $notification,
        ]);
    }
}

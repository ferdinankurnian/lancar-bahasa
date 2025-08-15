<?php

namespace Modules\Course\app\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseChapter;
use App\Models\CourseChapterItem;
use App\Models\CourseChapterLesson;
use App\Models\CoursePartnerInstructor;
use App\Models\CourseSelectedFilterOption;
use App\Models\CourseSelectedLanguage;
use App\Models\CourseSelectedLevel;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Modules\Course\app\Http\Requests\CourseStoreRequest;
use Modules\Course\app\Models\CourseCategory;
use Modules\Course\app\Models\CourseLanguage;
use Modules\Course\app\Models\CourseLevel;

class CourseController extends Controller
{
    function index(Request $request): View
    {
        getSessionCurrency();
        $query = Course::query();
        $query->when($request->keyword, fn ($q) => $q->where('title', 'like', '%' . request('keyword') . '%'));
        $query->when($request->category, function($q) use ($request) {
            $q->whereHas('category', function($q) use ($request) {
                $q->where('id', $request->category);
            });
        });
        $query->when($request->date && $request->filled('date'), fn($q) => $q->whereDate('created_at', $request->date));
        $query->when($request->approve_status && $request->filled('approve_status'), fn($q) => $q->where('is_approved', $request->approve_status));
        $query->when($request->status && $request->filled('status'), fn($q) => $q->where('status', $request->status));
        $query->when($request->instructor && $request->filled('instructor'), function($q) use ($request) {
            $q->where('instructor_id', $request->instructor);
        });
        $query->withCount('enrollments');
        $orderBy = $request->order_by == 1 ? 'asc' : 'desc';
        $courses = $request->par_page == 'all' ?
            $query->orderBy('id', $orderBy)->get() :
            $query->orderBy('id', $orderBy)->paginate($request->par_page ?? null)->withQueryString();
        $categories = CourseCategory::where('status', 1)->get();
        $instructors = User::where('role', 'instructor')->get();
        return view('course::course.index', compact('courses', 'categories', 'instructors'));
    }

    function create()
    {
        $instructors = User::where('role', 'instructor')->get();
        return view('course::course.create', compact('instructors'));
    }

    function editView(string $id)
    {
        Session::put('course_create', $id);
        $course = Course::findOrFail($id);
        $instructors = User::where('role', 'instructor')->get();
        $editMode = true;
        return view('course::course.create', compact('course', 'editMode', 'instructors'));
    }

    function store(CourseStoreRequest $request)
    {
        if ($request->edit_mode == 1) {
            $course = Course::findOrFail($request->id);
            $course->instructor_id = $request->instructor;
        } else {
            $course = new Course();
            $slug = generateUniqueSlug(Course::class, $request->title);
            $course->slug = $slug;
        }

        $course->title = $request->title;
        $course->seo_description = $request->seo_description;
        $course->thumbnail = $request->thumbnail;
        $course->demo_video_storage = $request->demo_video_storage;
        $course->demo_video_source = $request->demo_video_storage == 'upload' ? $request->upload_path : $request->external_path;
        $course->price = $request->price;
        $course->discount = $request->discount_price;
        $course->description = $request->description;
        $course->instructor_id = $request->instructor;
        $course->save();

        // save course id in session
        Session::put('course_create', $course->id);

        return response()->json([
            'status' => 'success',
            'message' => __('Updated successfully'),
            'redirect' => route('admin.courses.edit', ['id' => $course->id, 'step' => $request->next_step])
        ]);
    }

    function edit(Request $request)
    {
        if (!Session::get('course_create')) {
            return redirect(route('admin.courses.create'));
        }

        switch (request('step')) {
            case '1':
                $course = Course::findOrFail($request->id);
                $instructors = User::where('role', 'instructor')->get();
                $editMode = true;
                return view('course::course.create', compact('course', 'editMode', 'instructors'));
                break;
            case '2':
                $courseId = request('id');
                $categories = CourseCategory::where('status', 1)->get();
                $course = Course::findOrFail($courseId);
                $levels = CourseLevel::with(['translation'])->where('status', 1)->get();
                $category = CourseCategory::find($course->category_id);
                $languages = CourseLanguage::where('status', 1)->get();
                return view('course::course.more-information', compact(
                    'categories',
                    'courseId',
                    'course',
                    'levels',
                    'category',
                    'languages'
                ));
                break;
            case '3':
                $chapters = CourseChapter::with(['chapterItems'])->where(['course_id' => $request->id, 'status' => 'active'])->orderBy('order')->get();
                return view('course::course.course-content', compact('chapters'));
                break;
            case '4':
                $courseId = request('id');
                $course = Course::findOrFail($courseId);
                return view('course::course.finish', compact('course'));
                break;
            default:
                break;
        }
    }

    function update(Request $request)
    {
        switch ($request->step) {
            case '2':
                $request->validate([
                    'course_duration' => ['required', 'numeric', 'min:0'],
                    'category' => ['required']
                ]);
                $this->storeMoreInfo($request);
                return response()->json([
                    'status' => 'success',
                    'message' => __('Updated Successfully'),
                    'redirect' => route('admin.courses.edit', ['id' => Session::get('course_create'), 'step' => $request->next_step])
                ]);
                break;
            case '3':
                return response()->json([
                    'status' => 'success',
                    'message' => __('Updated successfully'),
                    'redirect' => route('admin.courses.edit', ['id' => Session::get('course_create'), 'step' => $request->next_step])
                ]);
            case '4':
                $request->validate([
                    'status' => ['required'],
                    'message_for_reviewer' => ['nullable', 'max:1000']
                ]);
                $this->storeFinish($request);
                return response()->json([
                    'status' => 'success',
                    'message' => __('Updated Successfully'),
                    'redirect' => $request->next_step == 4 ? route('admin.courses.index') : route('admin.courses.edit', ['id' => Session::get('course_create'), 'step' => $request->next_step])
                ]);

            default:
                # code...
                break;
        }
    }

    function storeMoreInfo(Request $request)
    {
        checkAdminHasPermissionAndThrowException('course.management');
        $course = Course::findOrFail($request->course_id);
        $course->capacity = $request->capacity;
        $course->duration = $request->course_duration;
        $course->category_id = $request->category;
        $course->qna = $request->qna;
        $course->downloadable = $request->downloadable;
        $course->certificate = $request->certificate;
        $course->partner_instructor = $request->partner_instructor;
        $course->save();

        // delete unselected partner instructor
        CoursePartnerInstructor::where('course_id', $course->id)
            ->whereNotIn('instructor_id', $request->partner_instructors ?? [])->delete();

        // insert partner instructor
        foreach ($request->partner_instructors ?? [] as $instructor) {
            CoursePartnerInstructor::updateOrCreate(
                ['course_id' => $course->id, 'instructor_id' => $instructor],
            );
        }

        // insert levels
        CourseSelectedLevel::where('course_id', $course->id)
            ->whereNotIn('level_id', $request->levels ?? [])->delete();

        foreach ($request->levels ?? [] as $level) {
            CourseSelectedLevel::updateOrCreate(
                ['course_id' => $course->id, 'level_id' => $level],
            );
        }

        //insert languages
        CourseSelectedLanguage::where('course_id', $course->id)
            ->whereNotIn('language_id', $request->languages ?? [])->delete();

        foreach ($request->languages ?? [] as $language) {
            CourseSelectedLanguage::updateOrCreate(
                ['course_id' => $course->id, 'language_id' => $language],
            );
        }
    }

    function storeFinish(Request $request) {
        checkAdminHasPermissionAndThrowException('course.management');
        $course = Course::findOrFail($request->course_id);
        $course->message_for_reviewer = $request->message_for_reviewer;
        $course->status = $request->status;
        // $course->is_approved = 'approved';
        $course->save();
    }

    function getInstructors(Request $request)
    {
        $instructors = User::where('role', 'instructor')
            ->where(function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->q . '%')
                    ->orWhere('email', 'like', '%' . $request->q . '%');
            })
            ->where('id', '!=', auth()->id())
            ->get();
        return response()->json($instructors);
    }

    function statusUpdate(Request $request, string $id) {
      $course = Course::findOrFail($id);
      $course->is_approved = $request->status;
      $course->save();
      return response(['status' => 'success', 'message' => __('Updated successfully')]);
    }

    function destroy(string $id) {
        checkAdminHasPermissionAndThrowException('course.management');
        $course = Course::findOrFail($id);
        if ($course->enrollments()->count() > 0) {
            return redirect()->back()->with(['alert-type' => 'error', 'messege' => __('The course cannot be deleted because it has enrollments.')]);
        }
        $course->delete();

        return response()->json(['status' => 'success', 'message' => __('Course deleted successfully')]);
    }
}

<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Quiz;
use App\Models\User;
use App\Models\Course;
use App\Models\QuizQuestion;
use Illuminate\Http\Request;
use App\Models\CourseChapter;
use App\Models\CourseLiveClass;
use App\Models\CourseChapterItem;
use App\Models\CourseChapterLesson;
use App\Services\MailSenderService;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Modules\Order\app\Models\Enrollment;
use App\Http\Requests\Frontend\ChapterLessonRequest;

class CourseContentController extends Controller {
    function chapterStore(Request $request, string $courseId): RedirectResponse {
        $request->validate([
            'title' => ['required', 'max:255'],
        ], [
            'title.required' => __('Title is required'),
            'title.max'      => __('Title is too long'),
        ]);

        $chapter = new CourseChapter();
        $chapter->title = $request->title;
        $chapter->course_id = $courseId;
        $chapter->instructor_id = auth('web')->id();
        $chapter->status = 'active';
        $chapter->order = CourseChapter::where('course_id', $courseId)->max('order') + 1;
        $chapter->save();

        return redirect()->back()->with(['messege' => __('Chapter created successfully'), 'alert-type' => 'success']);
    }

    function chapterEdit(string $chapterId) {
        $chapter = CourseChapter::find($chapterId);
        return view('frontend.instructor-dashboard.course.partials.edit-section-modal', compact('chapter'))->render();
    }

    function chapterUpdate(Request $request, string $chapterId) {
        $chapter = CourseChapter::findOrFail($chapterId);
        abort_if($chapter->instructor_id != auth('web')->user()->id, 403, __('unauthorized access'));
        $chapter->title = $request->title;
        $chapter->save();
        return redirect()->back()->with(['messege' => __('Updated successfully'), 'alert-type' => 'success']);
    }

    function chapterDestroy(string $chapterId) {
        $chapter = CourseChapter::findOrFail($chapterId);
        abort_if($chapter->instructor_id != auth('web')->user()->id, 403, __('unauthorized access'));
        $chapterItems = CourseChapterItem::where('chapter_id', $chapterId)
            ->where('instructor_id', auth('web')->user()->id)
            ->get();
        $lessonFiles = CourseChapterLesson::whereIn('chapter_item_id', $chapterItems->pluck('id'))->get();
        $quizIds = Quiz::whereIn('chapter_item_id', $chapterItems->pluck('id'))->pluck('id');
        $questionIds = QuizQuestion::whereIn('quiz_id', $quizIds)->pluck('id');

        // delete quizzes, questions, answers and lesson files
        QuizQuestion::whereIn('id', $questionIds)->delete();
        Quiz::whereIn('id', $quizIds)->delete();
        CourseChapterLesson::whereIn('id', $lessonFiles->pluck('id'))->delete();
        foreach ($lessonFiles as $lesson) {
            if (\File::exists(asset($lesson->file_path))) {
                \File::delete(asset($lesson->file_path));
            }

        }

        // delete chapter items and chapter
        CourseChapterItem::whereIn('id', $chapterItems->pluck('id'))->delete();
        $chapter->delete();

        return response()->json(['status' => 'success', 'message' => __('Question deleted successfully')]);
    }

    function chapterSorting(string $courseId) {
        $chapters = CourseChapter::where('course_id', $courseId)->orderBy('order', 'ASC')->get();
        return view('frontend.instructor-dashboard.course.partials.chapter-sorting-index', compact('chapters', 'courseId'))->render();
    }

    function chapterSortingStore(Request $request, string $courseId) {
        $newOrder = $request->chapter_ids;

        foreach ($newOrder as $key => $value) {
            $chapter = CourseChapter::where('course_id', $courseId)->find($value);
            $chapter->order = $key + 1;
            $chapter->save();
        }

        return redirect()->back()->with(['messege' => __('Updated successfully'), 'alert-type' => 'success']);
    }

    function lessonCreate(Request $request) {
        $courseId = $request->courseId;
        $chapterId = $request->chapterId;
        $chapters = CourseChapter::where('course_id', $courseId)->orderBy('order')->get();
        $type = $request->type;
        if ($request->type == 'lesson') {
            return view('frontend.instructor-dashboard.course.partials.lesson-create-modal', [
                'courseId'  => $courseId,
                'chapterId' => $chapterId,
                'chapters'  => $chapters,
                'type'      => $type,
            ])->render();
        } elseif ($request->type == 'document') {
            return view('frontend.instructor-dashboard.course.partials.document-create-modal', [
                'courseId'  => $courseId,
                'chapterId' => $chapterId,
                'chapters'  => $chapters,
                'type'      => $type,
            ])->render();
        } elseif ($request->type == 'quiz') {
            return view('frontend.instructor-dashboard.course.partials.quiz-create-modal', [
                'courseId'  => $courseId,
                'chapterId' => $chapterId,
                'chapters'  => $chapters,
                'type'      => $type,
            ])->render();
        } elseif ($request->type == 'live') {
            return view('frontend.instructor-dashboard.course.partials.live-create-modal', [
                'courseId'  => $courseId,
                'chapterId' => $chapterId,
                'chapters'  => $chapters,
                'type'      => $type,
            ])->render();
        }
    }

    function lessonStore(ChapterLessonRequest $request) {
        $chapterItem = CourseChapterItem::create([
            'instructor_id' => auth('web')->id(),
            'chapter_id'    => $request->chapter_id,
            'type'          => $request->type,
            'order'         => CourseChapterItem::whereChapterId($request->chapter_id)->count() + 1,
        ]);

        if ($request->type == 'lesson') {
            CourseChapterLesson::create([
                'title'           => $request->title,
                'description'     => $request->description,
                'instructor_id'   => auth('web')->id(),
                'course_id'       => $request->course_id,
                'chapter_id'      => $request->chapter_id,
                'chapter_item_id' => $chapterItem->id,
                'file_path'       => $request->source == 'upload' ? $request->upload_path : $request->link_path,
                'storage'         => $request->source,
                'file_type'       => $request->file_type,
                'volume'          => $request->volume,
                'duration'        => $request->duration,
                'is_free'         => $request->is_free,
            ]);
        } elseif ($request->type == 'document') {
            CourseChapterLesson::create([
                'title'           => $request->title,
                'description'     => $request->description,
                'instructor_id'   => auth('web')->id(),
                'course_id'       => $request->course_id,
                'chapter_id'      => $request->chapter_id,
                'chapter_item_id' => $chapterItem->id,
                'file_path'       => $request->upload_path,
                'file_type'       => $request->file_type,
            ]);
        } elseif ($request->type == 'live') {
            $chapter_lesson = CourseChapterLesson::create([
                'title'           => $request->title,
                'description'     => $request->description,
                'instructor_id'   => auth('web')->id(),
                'course_id'       => $request->course_id,
                'chapter_id'      => $request->chapter_id,
                'chapter_item_id' => $chapterItem->id,
                'duration'        => $request->duration,
                'storage'         => 'live',
                'file_type'       => 'live',
            ]);
            $start_time = date('Y-m-d H:i:s', strtotime($request->start_time));
            $join_url = $request?->live_type === 'zoom' ? $request->join_url : null;
            CourseLiveClass::create([
                'lesson_id'  => $chapter_lesson->id,
                'start_time' => $start_time,
                'meeting_id' => $request->meeting_id,
                'password'   => $request?->password ?? null,
                'join_url'   => $join_url,
                'type'       => $request->live_type,
            ]);
            if ($request?->student_mail_sent == 'on') {
                $user_ids = Enrollment::where('course_id',$chapter_lesson->course_id)->pluck('user_id')->toArray();
                $users = User::select('name', 'email')->whereIn('id', $user_ids)->get();
                $data = (object)[
                    'course' => Course::select('title')->where('id',$chapter_lesson->course_id)->first()->title,
                    'lesson' => $chapter_lesson->title,
                    'start_time' => formattedDateTime($start_time),
                    'join_url' => $join_url,
                ];
                (new MailSenderService)->sendLiveClassNotificationMailTrait($users,$data);

            }
        } elseif ($request->type == 'quiz') {
            Quiz::create([
                'chapter_item_id' => $chapterItem->id,
                'instructor_id'   => auth('web')->id(),
                'chapter_id'      => $request->chapter,
                'course_id'       => $request->course_id,
                'title'           => $request->title,
                'time'            => $request->time_limit,
                'attempt'         => $request->attempts,
                'pass_mark'       => $request->pass_mark,
                'total_mark'      => $request->total_mark,
            ]);
        }

        return response()->json(['status' => 'success', 'message' => __('Lesson created successfully')]);
    }

    function lessonEdit(Request $request) {
        $courseId = $request->courseId;
        $chapterItemId = $request->chapterItemId;
        $chapterItem = CourseChapterItem::with(['lesson', 'quiz'])->find($chapterItemId);
        $chapters = CourseChapter::where('course_id', $courseId)->get();
        if ($request->type == 'lesson') {
            return view('frontend.instructor-dashboard.course.partials.lesson-edit-modal', [
                'chapters'    => $chapters,
                'courseId'    => $courseId,
                'chapterItem' => $chapterItem,
            ])->render();
        } elseif ($request->type == 'document') {
            return view('frontend.instructor-dashboard.course.partials.document-edit-modal', [
                'chapters'    => $chapters,
                'courseId'    => $courseId,
                'chapterItem' => $chapterItem,
            ])->render();
        } elseif ($request->type == 'live') {
            return view('frontend.instructor-dashboard.course.partials.live-edit-modal', [
                'chapters'    => $chapters,
                'courseId'    => $courseId,
                'chapterItem' => $chapterItem,
            ])->render();
        } else {
            return view('frontend.instructor-dashboard.course.partials.quiz-edit-modal', [
                'chapters'    => $chapters,
                'courseId'    => $courseId,
                'chapterItem' => $chapterItem,
            ])->render();
        }
    }

    function lessonUpdate(ChapterLessonRequest $request) {
        $chapterItem = CourseChapterItem::findOrFail($request->chapter_item_id);
        abort_if($chapterItem->instructor_id != auth('web')->user()->id, 403, __('unauthorized access'));
        $chapterItem->update([
            'chapter_id' => $request->chapter,
        ]);

        if ($request->type == 'lesson') {
            $courseChapterLesson = CourseChapterLesson::where('chapter_item_id', $chapterItem->id)->first();
            
            $old_file_path = $courseChapterLesson->file_path;
            if (in_array($courseChapterLesson->storage, ['wasabi', 'aws']) && $old_file_path != $request->link_path) {
                $disk = Storage::disk($courseChapterLesson->storage);
                $disk->exists($old_file_path) && $disk->delete($old_file_path);
            }

            $courseChapterLesson->update([
                'title'           => $request->title,
                'description'     => $request->description,
                'course_id'       => $chapterItem->course_id,
                'chapter_id'      => $chapterItem->chapter_id,
                'chapter_item_id' => $chapterItem->id,
                'file_path'       => $request->source == 'upload' ? $request->upload_path : $request->link_path,
                'storage'         => $request->source,
                'file_type'       => $request->file_type,
                'volume'          => $request->volume,
                'duration'        => $request->duration,
                'is_free'         => $request->is_free,
            ]);
        } elseif ($request->type == 'live') {

            $courseChapterLesson = CourseChapterLesson::where('chapter_item_id', $chapterItem->id)->first();
            $courseChapterLesson->update([
                'title'           => $request->title,
                'description'     => $request->description,
                'chapter_id'      => $chapterItem->chapter_id,
                'chapter_item_id' => $chapterItem->id,
                'duration'        => $request->duration,
                'storage'         => $request->source ? $request->source : 'live',
                'file_type'       => $request->source ? 'video' : 'live',
                'file_path'       => $request->source ? ($request->source == 'upload' ? $request->upload_path : $request->link_path) : null,
            ]);

            $start_time = date('Y-m-d H:i:s', strtotime($request->start_time));
            $join_url = $request?->live_type === 'zoom' ? $request->join_url : null;
            CourseLiveClass::where('lesson_id', $courseChapterLesson->id)->update([
                'start_time' => $start_time,
                'meeting_id' => $request->meeting_id,
                'password'   => $request?->password ?? null,
                'join_url'   => $join_url,
                'type'       => $request->live_type,
            ]);

            if ($request?->student_mail_sent == 'on') {
                $user_ids = Enrollment::where('course_id',$courseChapterLesson->course_id)->pluck('user_id')->toArray();
                $users = User::select('name', 'email')->whereIn('id', $user_ids)->get();
                $data = (object)[
                    'course' => Course::select('title')->where('id',$courseChapterLesson->course_id)->first()->title,
                    'lesson' => $courseChapterLesson->title,
                    'start_time' => formattedDateTime($start_time),
                    'join_url' => $join_url,
                ];
                (new MailSenderService)->sendLiveClassNotificationMailTrait($users,$data);

            }
        } elseif ($request->type == 'document') {
            $courseChapterLesson = CourseChapterLesson::where('chapter_item_id', $chapterItem->id)->first();
            $courseChapterLesson->update([
                'title'           => $request->title,
                'description'     => $request->description,
                'course_id'       => $chapterItem->course_id,
                'chapter_id'      => $chapterItem->chapter_id,
                'chapter_item_id' => $chapterItem->id,
                'file_path'       => $request->upload_path,
                'file_type'       => $request->file_type,
            ]);
        } else {
            $quiz = Quiz::where('chapter_item_id', $chapterItem->id)->first();
            $quiz->update([
                'chapter_item_id' => $chapterItem->id,
                'title'           => $request->title,
                'time'            => $request->time_limit,
                'attempt'         => $request->attempts,
                'pass_mark'       => $request->pass_mark,
                'total_mark'      => $request->total_mark,
            ]);
        }

        return response()->json(['status' => 'success', 'message' => __('Lesson updated successfully')]);
    }

    function sortLessons(Request $request, string $chapterId) {
        $newOrder = $request->orderIds;
        foreach ($newOrder as $key => $itemId) {
            $chapterItem = CourseChapterItem::where(['chapter_id' => $chapterId, 'id' => $itemId])->first();
            $chapterItem->order = $key + 1;
            $chapterItem->save();
        }

        return response()->json(['status' => 'success', 'message' => __('Lesson sorted successfully')]);
    }

    function chapterLessonDestroy(string $chapterItemId) {
        $chapterItem = CourseChapterItem::findOrFail($chapterItemId);
        abort_if($chapterItem->instructor_id != auth('web')->user()->id, 403, __('unauthorized access'));

        if ($chapterItem->type == 'quiz') {
            $quiz = $chapterItem->quiz;
            $question = $quiz->questions;
            foreach ($question as $key => $question) {
                $question->answers()->delete();
                $question->delete();
            }
            $quiz->delete();
            $chapterItem->delete();
        } else {
            if (in_array($chapterItem->lesson->storage, ['wasabi', 'aws'])) {
                $disk = Storage::disk($chapterItem->lesson->storage);
                $filePath = $chapterItem->lesson->file_path;
                $disk->exists($filePath) && $disk->delete($filePath);
            }
            // delete chapter item lesson if file exists
            if (\File::exists(asset($chapterItem->lesson->file_path))) {
                \File::delete(asset($chapterItem->lesson->file_path));
            }

            // delete lesson row
            $chapterItem->lesson()->delete();
            $chapterItem->delete();
        }

        return response()->json(['status' => 'success', 'message' => __('Lesson deleted successfully')]);
    }

    function createQuizQuestion(string $quizId) {
        return view('frontend.instructor-dashboard.course.partials.quiz-question-create-modal', ['quizId' => $quizId])->render();
    }

    function storeQuizQuestion(Request $request, string $quizId) {
        $request->validate([
            'title'     => ['required', 'max:255'],
            'answers.*' => ['required', 'max:255'],
            'grade'     => ['required', 'numeric', 'min:0'],
        ], [
            'title.required'     => __('Question title is required'),
            'title.max'          => __('Question title should not be more than 255 characters'),
            'answers.*.required' => __('At least one answer is required'),
            'answers.*.max'      => __('Answer should not be more than 255 characters'),
            'grade.required'     => __('Grade is required'),
            'grade.numeric'      => __('Grade should be a number'),
            'grade.min'          => __('Grade should be greater than or equal to 0'),
        ]);

        $question = QuizQuestion::create([
            'quiz_id' => $quizId,
            'title'   => $request->title,
            'grade'   => $request->grade,
        ]);

        foreach ($request->answers as $key => $answer) {
            $question->answers()->create([
                'title'       => $answer,
                'correct'     => isset($request->correct[$key]) ? 1 : 0,
                'question_id' => $question->id,
            ]);
        }

        return response()->json(['status' => 'success', 'message' => __('Question created successfully')]);

    }

    function editQuizQuestion(string $questionId) {
        $question = QuizQuestion::findOrFail($questionId);
        return view('frontend.instructor-dashboard.course.partials.quiz-question-edit-modal', ['question' => $question])->render();
    }

    function updateQuizQuestion(Request $request, string $questionId) {
        $request->validate([
            'title'     => ['required', 'max:255'],
            'answers.*' => ['required', 'max:255'],
            'grade'     => ['required', 'numeric', 'min:0'],
        ], [
            'title.required'     => __('Question title is required'),
            'title.max'          => __('Question title should not be more than 255 characters'),
            'answers.*.required' => __('At least one answer is required'),
            'answers.*.max'      => __('Answer should not be more than 255 characters'),
            'grade.required'     => __('Grade is required'),
            'grade.numeric'      => __('Grade should be a number'),
            'grade.min'          => __('Grade should be greater than or equal to 0'),
        ]);

        $question = QuizQuestion::findOrFail($questionId);
        $question->update([
            'title' => $request->title,
            'grade' => $request->grade,
        ]);
        // update or delete answers
        $question->answers()->delete();
        foreach ($request->answers as $key => $answer) {
            $question->answers()->create([
                'title'       => $answer,
                'correct'     => isset($request->correct[$key]) ? 1 : 0,
                'question_id' => $question->id,
            ]);
        }

        return response()->json(['status' => 'success', 'message' => __('Question updated successfully')]);
    }

    function destroyQuizQuestion(string $questionId) {
        $question = QuizQuestion::findOrFail($questionId);
        $question->answers()->delete();
        $question->delete();
        return response()->json(['status' => 'success', 'message' => __('Question deleted successfully')]);
    }
}

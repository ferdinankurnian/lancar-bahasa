<?php

namespace App\Http\Controllers\Frontend;

use App\Models\LessonReply;
use Illuminate\Http\Request;
use App\Models\LessonQuestion;
use App\Rules\CustomRecaptcha;
use App\Services\MailSenderService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class InstructorLessonQnaController extends Controller {
    function index(Request $request) {
        $query = LessonQuestion::query();
        $query->select('id', 'user_id', 'seen', 'course_id', 'lesson_id', 'question_title', 'question_description', 'created_at')->with(['course' => function ($query) {
            $query->select('id', 'slug', 'title', 'thumbnail');
        }, 'lesson' => function ($query) {
            $query->select('id','chapter_item_id', 'title')->with(['chapterItem' => function ($query) {
                $query->select('id', 'type');
            }]);
        }, 'user' => function ($query) {
            $query->select('id', 'name', 'image');
        }, 'replies'])->whereHas('course', function ($query) {
            $query->whereNotNull('id');
        })->withCount('replies');

        $query->when($request->filled('seen'), function ($q) use ($request) {
            $q->where('seen', $request->seen);
        });
        $orderBy = $request->filled( 'sort_by' ) && $request->sort_by == 1 ? 'asc' : 'desc';
        $lesson_questions = $query->orderBy( 'id', $orderBy )->paginate(10)->withQueryString();
        return view('frontend.instructor-dashboard.lesson-qna.index', compact('lesson_questions'));
    }
    function destroyQuestion($id) {
        $question = LessonQuestion::where('id', $id)->first();
        if ($question) {
            $question->replies()->delete();
            extractAndFilterImageSrc($question?->question_description);
            $question->delete();

            $notification = ['messege' => __('Question deleted successfully'), 'alert-type' => 'success'];
            return back()->with($notification);
        }
        $notification = ['messege' => __('Something went wrong'), 'alert-type' => 'error'];
        return back()->with($notification);

    }
    function createReply(Request $request, $id) {
        $messages = [
            'reply.required'                => __('Replay is required'),
            'g-recaptcha-response.required' => __('Please complete the recaptcha to submit the form'),
        ];
        $request->validate([
            'reply'                => ['required', 'string'],
            'g-recaptcha-response' => Cache::get('setting')->recaptcha_status === 'active' ? ['required', new CustomRecaptcha()] : 'nullable',
        ], $messages);

        $reply = LessonReply::create([
            'user_id'     => userAuth()->id,
            'question_id' => $id,
            'reply'       => $request->reply,
        ]);
        $question = LessonQuestion::where('id', $id)->select('id', 'user_id', 'seen', 'course_id', 'lesson_id', 'question_title')->with(['course' => function ($query) {
            $query->select('id', 'slug', 'title');
        }, 'lesson' => function ($query) {
            $query->select('id','chapter_item_id', 'title')->with(['chapterItem' => function ($query) {
                $query->select('id', 'type');
            }]);
        }, 'user' => function ($query) {
            $query->select('id', 'name','email');
        }])->first();
        
        $question->update(['seen' => true]);
        
        (new MailSenderService)->sendQnaReplyMailTrait($question);
        
        $notification = ['messege' => __('Reply created successfully'), 'alert-type' => 'success'];
        return back()->with($notification);
    }
    function destroyReply($id) {
        $reply = LessonReply::where('id', $id)->first();
        if ($reply) {
            extractAndFilterImageSrc($reply?->reply);
            $reply->delete();
            $notification = ['messege' => __('Reply deleted successfully'), 'alert-type' => 'success'];
            return back()->with($notification);
        }
        $notification = ['messege' => __('Something went wrong'), 'alert-type' => 'error'];
        return back()->with($notification);
    }
    public function markAsReadUnread($id) {
        $question = LessonQuestion::find($id);
        $seen = $question->seen == 1 ? 0 : 1;
        $question->update(['seen' => $seen]);

        $notification = __('Updated Successfully');

        return response()->json([
            'success' => true,
            'title' => $question->seen == 1 ? __('Mark read') : __('Mark as unread'),
            'message' => $notification,
        ]);
    }
}

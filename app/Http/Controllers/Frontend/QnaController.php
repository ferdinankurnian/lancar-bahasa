<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Course;
use App\Models\LessonReply;
use Illuminate\Http\Request;
use App\Models\LessonQuestion;
use App\Rules\CustomRecaptcha;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class QnaController extends Controller {

    function create(Request $request) {
        $messages = [
            'question.required'             => __('Question is required'),
            'question.max'                  => __('Question may not be greater than 255 characters'),
            'description.required'          => __('Description is required'),
            'g-recaptcha-response.required' => __('Please complete the recaptcha to submit the form'),
        ];
        $request->validate([
            'question'             => ['required', 'max:255'],
            'description'          => ['required'],
            'g-recaptcha-response' => Cache::get('setting')->recaptcha_status === 'active' ? ['required', new CustomRecaptcha()] : 'nullable',
        ], $messages);

        $question = LessonQuestion::create([
            'user_id'              => userAuth()->id,
            'lesson_id'            => $request->lesson_id,
            'course_id'            => $request->course_id,
            'question_title'       => $request->question,
            'question_description' => $request->description,
        ]);

        return response()->json([
            'status'   => 'success',
            'message'  => __('Question created successfully'),
            'question' => $question,
        ], 200);
    }

    function fetchLessonQuestions(Request $request) {
        $query = LessonQuestion::query();
        $query->withCount('replies');

        $query->when($request->has('query') && strlen($requestQuery = $request->query('query')) > 0, function ($q) use ($requestQuery) {
            $q->where('question_title', 'like', '%' . $requestQuery . '%');
        });
        $query->when($request->filled('filter') && $request->filter == 'current_lecture', function ($q) use ($request) {
            $q->where('lesson_id', $request->lesson_id);
        });
        $query->where('course_id', $request->course_id);

        $questions = $query->paginate(8, ['*'], 'page', $request->page ?: 1);

        return response()->json([
            'view'       => view('frontend.pages.learning-player.partials.question-card', compact('questions'))->render(),
            'page'       => $request->page,
            'last_page'  => $questions->lastPage(),
            'data_count' => $questions->count(),
        ]);
    }

    function createReply(Request $request) {
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
            'question_id' => $request->question_id,
            'reply'       => $request->reply,
        ]);
        $lesson_question = LessonQuestion::find($request->question_id);
        if ($lesson_question && Course::where('id', $lesson_question->course_id)
                ->where('instructor_id', '<>', userAuth()->id)
                ->exists()) {
            $lesson_question->update(['seen' => false]);
        }

        return response()->json([
            'status'   => 'success',
            'message'  => __('Reply created successfully'),
            'question' => $reply,
        ], 200);
    }

    function fetchReply(Request $request) {
        $question = LessonQuestion::with('user')->where('id', $request->question_id)->first();
        $replies = LessonReply::where('question_id', $request->question_id)->get();
        return view('frontend.pages.learning-player.partials.reply-card', compact('replies', 'question'))->render();
    }

    function destroyReply(string $id) {
        $reply = LessonReply::where(['user_id' => userAuth()->id, 'id' => $id])->first();
        if ($reply) {
            extractAndFilterImageSrc($reply?->reply);
            $reply->delete();
            return response()->json([
                'status'  => 'success',
                'message' => __('Reply deleted successfully'),
            ], 200);
        }
        return response()->json([
            'status'  => 'error',
            'message' => __('Something went wrong'),
        ]);
    }

    function destroyQuestion(string $id) {

        $question = LessonQuestion::where(['user_id' => userAuth()->id, 'id' => $id])->first();
        if ($question) {
            $question->replies()->delete();
            extractAndFilterImageSrc($question?->question_description);
            $question->delete();

            return response()->json([
                'status'  => 'success',
                'message' => __('Question deleted successfully'),
            ], 200);
        }
        return response()->json([
            'status'  => 'error',
            'message' => __('Something went wrong'),
        ]);

    }
}

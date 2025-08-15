<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseChapterItem;
use App\Models\CourseProgress;
use App\Models\CourseReview;
use App\Models\QuizResult;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Modules\CertificateBuilder\app\Models\CertificateBuilder;
use Modules\CertificateBuilder\app\Models\CertificateBuilderItem;
use Modules\Order\app\Models\Enrollment;
use Modules\Order\app\Models\Order;

class StudentDashboardController extends Controller {
    public function index(): View {
        $totalEnrolledCourses = Enrollment::where('user_id', userAuth()->id)->count();
        $totalQuizAttempts = QuizResult::where('user_id', userAuth()->id)->count();
        $totalReviews = CourseReview::where('user_id', userAuth()->id)->count();
        $orders = Order::where('buyer_id', userAuth()->id)->orderBy('id', 'desc')->take(10)->get();
        return view('frontend.student-dashboard.index', compact(
            'totalEnrolledCourses',
            'totalQuizAttempts',
            'totalReviews',
            'orders'
        ));
    }

    function enrolledCourses() {
        $enrolls = Enrollment::with(['course' => function ($q) {
            $q->withTrashed();
        }])->where('user_id', userAuth()->id)->orderByDesc('id')->paginate(10);
        return view('frontend.student-dashboard.enrolled-courses.index', compact('enrolls'));
    }

    function quizAttempts() {
        Session::forget('course_slug');
        $quizAttempts = QuizResult::with(['quiz'])->where('user_id', userAuth()->id)->orderByDesc('id')->paginate(10);

        return view('frontend.student-dashboard.quiz-attempts.index', compact('quizAttempts'));
    }

    function downloadCertificate(string $id) {
        $certificate = CertificateBuilder::first();
        $certificateItems = CertificateBuilderItem::all();
        $course = Course::withTrashed()->find($id);

        $courseLectureCount = CourseChapterItem::whereHas('chapter', function ($q) use ($course) {
            $q->where('course_id', $course->id);
        })->count();

        $courseLectureCompletedByUser = CourseProgress::where('user_id', userAuth()->id)
            ->where('course_id', $course->id)->where('watched', 1)->latest();

        $completed_date = formatDate($courseLectureCompletedByUser->first()?->created_at);

        $courseLectureCompletedByUser = CourseProgress::where('user_id', userAuth()->id)
            ->where('course_id', $course->id)->where('watched', 1)->count();

        $courseCompletedPercent = $courseLectureCount > 0 ? ($courseLectureCompletedByUser / $courseLectureCount) * 100 : 0;

        if ($courseCompletedPercent != 100) {
            return abort(404);
        }

        $html = view('frontend.student-dashboard.certificate.index', compact('certificateItems', 'certificate'))->render();

        $html = str_replace('[student_name]', userAuth()->name, $html);
        $html = str_replace('[platform_name]', Cache::get('setting')->app_name, $html);
        $html = str_replace('[course]', $course->title, $html);
        $html = str_replace('[date]', formatDate($completed_date), $html);
        $html = str_replace('[instructor_name]', $course->instructor->name, $html);

        // Initialize Dompdf
        $dompdf = new Dompdf(array('enable_remote' => true));

        // Load HTML content
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');

        $dompdf->render();
        $dompdf->stream("certificate.pdf");
        return redirect()->back();
    }
}

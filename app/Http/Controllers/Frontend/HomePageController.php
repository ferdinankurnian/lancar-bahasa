<?php

namespace App\Http\Controllers\Frontend;

use App\Enums\ThemeList;
use App\Http\Controllers\Controller;
use App\Jobs\DefaultMailJob;
use App\Mail\DefaultMail;
use App\Models\Course;
use App\Models\User;
use App\Models\UserEducation;
use App\Models\UserExperience;
use App\Rules\CustomRecaptcha;
use App\Traits\MailSenderTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Modules\Badges\app\Models\Badge;
use Modules\Blog\app\Models\Blog;
use Modules\Brand\app\Models\Brand;
use Modules\Course\app\Models\CourseCategory;
use Modules\Course\app\Models\CourseLanguage;
use Modules\Faq\app\Models\Faq;
use Modules\Frontend\app\Models\FeaturedCourseSection;
use Modules\Frontend\app\Models\FeaturedInstructor;
use Modules\Frontend\app\Models\Section;
use Modules\GlobalSetting\app\Models\EmailTemplate;
use Modules\Location\app\Models\City;
use Modules\Location\app\Models\Country;
use Modules\Location\app\Models\State;
use Modules\PageBuilder\app\Models\CustomPage;
use Modules\SiteAppearance\app\Models\SectionSetting;
use Modules\Testimonial\app\Models\Testimonial;

class HomePageController extends Controller {
    use MailSenderTrait;

    function index(): View {
        $theme_name = Session::has('demo_theme') ? Session::get('demo_theme') : config('app.default_homepage');

        $sections = Section::whereHas("home", function ($q) use ($theme_name) {
            $q->where('slug', $theme_name);
        })->get();

        $hero = $sections->where('name', 'hero_section')->first();
        $slider = $sections->where('name', 'slider_section')->first();
        $aboutSection = $sections->where('name', 'about_section')->first();
        $newsletterSection = $sections->where('name', 'newsletter_section')->first();
        $counter = $sections->where('name', 'counter_section')->first();
        $ourFeatures = $sections->where('name', 'our_features_section')->first();
        $bannerSection = $sections->where('name', 'banner_section')->first();
        $faqSection = $sections->where('name', 'faq_section')->first();

        $faqs = Faq::with('translation')->where('status', 1)->get();

        $courseLanguages = CourseLanguage::where('status', 1)->whereNotNull('image')->get();

        $brands = Brand::where('status', 1)->get();

        $featuredCourse = FeaturedCourseSection::first();

        $featuredInstructorSection = FeaturedInstructor::first();
        $instructorIds = json_decode($featuredInstructorSection->instructor_ids ?? '[]');

        $selectedInstructors = User::whereIn('id', $instructorIds)
            ->with(['courses' => function ($query) {
                $query->withCount(['reviews as avg_rating' => function ($query) {
                    $query->select(DB::raw('coalesce(avg(rating),0)'));
                }]);
            }])
            ->get();

        $testimonials = Testimonial::all();

        $featuredBlogs = Blog::with(['translation', 'author'])
            ->whereHas('category', function ($q) {$q->where('status', 1);})
            ->where(['show_homepage' => 1, 'status' => 1])->orderBy('created_at', 'desc')->limit(4)->get();
        $sectionSetting = SectionSetting::first();

        return view('frontend.home.' . $theme_name . '.index', compact(
            'hero',
            'slider',
            'courseLanguages',
            'brands',
            'aboutSection',
            'featuredCourse',
            'newsletterSection',
            'featuredInstructorSection',
            'selectedInstructors',
            'counter',
            'faqSection',
            'faqs',
            'testimonials',
            'ourFeatures',
            'bannerSection',
            'featuredBlogs',
            'sectionSetting'
        ));
    }

    function countries(): JsonResponse {
        $countries = Country::where('status', 1)->get();
        return response()->json($countries);
    }

    function states(string $id): JsonResponse {
        $states = State::where(['country_id' => $id, 'status' => 1])->get();
        return response()->json($states);
    }

    function cities(string $id): JsonResponse {
        $cities = City::where(['state_id' => $id, 'status' => 1])->get();
        return response()->json($cities);
    }

    public function setCurrency() {
        $currency = allCurrencies()->where('currency_code', request('currency'))->first();
        if (session()->has('currency_code')) {
            session()->forget('currency_code');
            session()->forget('currency_position');
            session()->forget('currency_icon');
            session()->forget('currency_rate');
        }
        if ($currency) {
            session()->put('currency_code', $currency->currency_code);
            session()->put('currency_position', $currency->currency_position);
            session()->put('currency_icon', $currency->currency_icon);
            session()->put('currency_rate', $currency->currency_rate);

            $notification = __('Currency Changed Successfully');
            $notification = ['messege' => $notification, 'alert-type' => 'success'];

            return redirect()->back()->with($notification);
        }
        getSessionCurrency();
        $notification = __('Currency Changed Successfully');
        $notification = ['messege' => $notification, 'alert-type' => 'success'];

        return redirect()->back()->with($notification);
    }

    function instructorDetails(string $id) {
        User::where(['status' => 'active', 'is_banned' => 0, 'id' => $id])->first();
        $instructor = User::where(['status' => 'active', 'is_banned' => 0, 'id' => $id])->with(['courses' => function ($query) {
            $query->withCount(['reviews as avg_rating' => function ($query) {
                $query->select(DB::raw('coalesce(avg(rating),0)'));
            }]);
        }])
            ->firstOrFail();
        $experiences = UserExperience::where(['user_id' => $id])->get();
        $educations = UserEducation::where(['user_id' => $id])->get();
        $courses = Course::active()->where(['instructor_id' => $id])->orderBy('id', 'desc')->get();
        $badges = Badge::where(['status' => 1])->get()->groupBy('key');
        return view('frontend.pages.instructor-details', compact('instructor', 'experiences', 'educations', 'courses', 'badges'));
    }

    function allInstructors() {
        $instructors = User::where(['status' => 'active', 'is_banned' => 0, 'role' => 'instructor'])
            ->withCount('courses as course_count')
            ->with(['courses' => function ($query) {
                $query->withCount(['reviews as avg_rating' => function ($query) {
                    $query->select(DB::raw('coalesce(avg(rating),0)'));
                }]);
            }])
            ->orderByDesc('course_count')
            ->paginate(18);

        return view('frontend.pages.all-instructors', compact('instructors'));
    }

    function quickConnect(Request $request, string $id) {
        $validated = $request->validate([
            'name'                 => ['required', 'string', 'max:255'],
            'email'                => ['required', 'string', 'email', 'max:255'],
            'subject'              => ['required', 'string', 'max:255'],
            'message'              => ['required', 'string', 'max:1000'],
            'g-recaptcha-response' => Cache::get('setting')->recaptcha_status == 'active' ? ['required', new CustomRecaptcha()] : 'nullable',
        ]);

        $settings = cache()->get('setting');
        $marketingSettings = cache()->get('marketing_setting');
        if ($settings->google_tagmanager_status == 'active' && $marketingSettings->instructor_contact) {
            $instructor_contact = [
                'name'    => $request->name,
                'email'   => $request->email,
                'subject' => $request->subject,
                'message' => $request->message,
            ];
            session()->put('instructorQuickContact', $instructor_contact);
        }

        $this->handleMailSending($validated);
        return redirect()->back()->with(['messege' => __('Message sent successfully'), 'alert-type' => 'success']);
    }

    function handleMailSending(array $mailData) {
        self::setMailConfig();

        // Get email template
        $template = EmailTemplate::where('name', 'instructor_quick_contact')->firstOrFail();

        // Prepare email content
        $message = str_replace('{{name}}', $mailData['name'], $template->message);
        $message = str_replace('{{email}}', $mailData['email'], $message);
        $message = str_replace('{{subject}}', $mailData['subject'], $message);
        $message = str_replace('{{message}}', $mailData['message'], $message);

        if (self::isQueable()) {
            DefaultMailJob::dispatch($mailData['email'], $mailData, $message);
        } else {
            Mail::to($mailData['email'])->send(new DefaultMail($mailData, $message));
        }
    }

    function customPage(string $slug) {
        $page = CustomPage::where('slug', $slug)->firstOrFail();
        return view('frontend.pages.custom-page', compact('page'));
    }

    function changeTheme(string $theme) {
        if (Cache::get('setting')?->show_all_homepage != 1) {
            abort(404);
        }

        foreach (ThemeList::cases() as $enumTheme) {
            if ($theme == $enumTheme->value) {
                Session::put('demo_theme', $enumTheme->value);
                break;
            }
        }
        return redirect('/');
    }
}
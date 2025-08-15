<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Modules\Brand\app\Models\Brand;
use Modules\Faq\app\Models\Faq;
use Modules\Frontend\app\Models\Section;
use Modules\Testimonial\app\Models\Testimonial;

class AboutPageController extends Controller {
    function index(): View {
        $theme_name = Session::has('demo_theme') ? Session::get('demo_theme') : DEFAULT_HOMEPAGE;

        $sections = Section::whereHas("home", function ($q) use ($theme_name) {
            $q->where('slug', $theme_name);
        })->get();

        $hero = $sections->where('name', 'hero_section')->first();
        $aboutSection = $sections->where('name', 'about_section')->first();
        $ourFeatures = $sections->where('name', 'our_features_section')->first();
        $newsletterSection = $sections->where('name', 'newsletter_section')->first();

        $brands = Brand::where('status', 1)->get();
        $reviews = Testimonial::all();
        $faqs = Faq::with('translation')->where('status', 1)->get();
        $faqSection = $sections->where('name', 'faq_section')->first();
        return view('frontend.pages.about-us', compact('aboutSection',  'ourFeatures', 'newsletterSection', 'hero', 'brands', 'reviews', 'faqSection', 'faqs'));
    }
}

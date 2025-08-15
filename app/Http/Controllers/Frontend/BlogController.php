<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Rules\CustomRecaptcha;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Modules\Blog\app\Models\Blog;
use Modules\Blog\app\Models\BlogCategory;
use Modules\Blog\app\Models\BlogComment;

class BlogController extends Controller
{
    function index() {
        $query = Blog::query();
        $query->when(request('search'), function($query) {
            $query->whereHas('translation', function($query) {
                $query->where('title', 'like', '%' . request('search') . '%')
                    ->orWhere('description', 'like', '%' . request('search') . '%');
            });
        });
        $query->when(request('category'), function($query) {
            $query->whereHas('category', function($query) {
                $query->where('slug', request('category'));
            });
        });
        $query->whereHas('category', function($q) { $q->where('status', 1); });
        $blogs = $query->where(['status' => 1])->orderBy('created_at', 'desc')->paginate(9);

        $categories = BlogCategory::where('status', 1)->get();
        $popularBlogs = Blog::where(['status' => 1])->whereHas('category', function($q) { $q->where('status', 1); })->where('is_popular', 1)->orderBy('created_at', 'desc')->limit(8)->get();
        return view('frontend.pages.blog', compact('blogs', 'categories', 'popularBlogs'));
    }

    function show(string $slug) {
       $blog = Blog::where('slug', $slug)->whereHas('category', function($q) { $q->where('status', 1); })->firstOrFail();
       $latestBlogs = Blog::where(['status' => 1])->where('id', '!=', $blog->id)->orderBy('created_at', 'desc')->limit(8)->get();
       $categories = BlogCategory::where('status', 1)->get();
       $comments = BlogComment::where(['blog_id' => $blog->id])->where('status', 1)->orderBy('created_at', 'desc')->get();

       return view('frontend.pages.blog-details', compact('blog', 'latestBlogs', 'categories', 'comments'));
    }

    function submitComment(Request $request) {
       $request->validate([
        'comment' => ['required', 'max:1000'], 
        'g-recaptcha-response' => Cache::get('setting')->recaptcha_status == 'active' ? ['required', new CustomRecaptcha()] : 'nullable',
       ], [
        'comment.required' => __('The comment field is required'),
        'comment.max' => __('The comment must not be greater than 1000 characters'),
        'g-recaptcha-response.required' => __('The reCAPTCHA verification is required'),
        'g-recaptcha-response.recaptcha' => __('The reCAPTCHA verification failed'),
       ]);
       $comment = new BlogComment();

       $comment->blog_id = $request->blog_id;
       $comment->user_id = userAuth()->id;
       $comment->comment = $request->comment;
       $comment->save();
       return redirect()->back()->withFragment('comments')->with(['messege' => __('Comment added successfully. waiting for approval'), 'alert-type' => 'success']);
    }
}

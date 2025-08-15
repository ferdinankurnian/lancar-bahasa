<?php

namespace Modules\NewsLetter\app\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Services\MailSenderService;
use App\Http\Controllers\Controller;
use Modules\NewsLetter\app\Models\NewsLetter;
use Modules\NewsLetter\app\Jobs\SendMailToNewsletterJob;

class NewsLetterController extends Controller
{
    public function index()
    {
        checkAdminHasPermissionAndThrowException('newsletter.view');
        $newsletters = NewsLetter::orderBy('id', 'desc')->where('status', 'verified')->get();

        return view('newsletter::index', ['newsletters' => $newsletters]);
    }

    public function create()
    {
        checkAdminHasPermissionAndThrowException('newsletter.mail');

        return view('newsletter::create');
    }

    public function destroy($id)
    {
        checkAdminHasPermissionAndThrowException('newsletter.delete');
        $newsletter = NewsLetter::find($id);
        $newsletter->delete();

        $notification = __('Deleted successfully');
        $notification = ['messege' => $notification, 'alert-type' => 'success'];

        return redirect()->back()->with($notification);
    }

    public function store(Request $request)
    {
        checkAdminHasPermissionAndThrowException('newsletter.mail');
        $request->validate([
            'subject' => 'required',
            'description' => 'required',
        ], [
            'subject.required' => __('Subject is required'),
            'description.required' => __('Description is required'),
        ]);

        (new MailSenderService)->SendMailToNewsletterFromTrait($request->subject, $request->description);

        $notification = __('Mail send successfully');
        $notification = ['messege' => $notification, 'alert-type' => 'success'];

        return redirect()->back()->with($notification);
    }
}

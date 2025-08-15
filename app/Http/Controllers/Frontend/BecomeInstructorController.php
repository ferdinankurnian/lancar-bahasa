<?php

namespace App\Http\Controllers\Frontend;

use App\Enums\UserStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\BecomeInstructorStoreRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Modules\InstructorRequest\app\Models\InstructorRequest;
use Modules\InstructorRequest\app\Models\InstructorRequestSetting;
use Modules\PaymentWithdraw\app\Models\WithdrawMethod;

class BecomeInstructorController extends Controller
{

    function index(): View|RedirectResponse
    {
        if ($this->checkIfApproveInstructor()) return to_route('instructor.dashboard');

        $instructorRequestSetting = InstructorRequestSetting::first();
        $withdrawMethods = WithdrawMethod::where('status', 'active')->get();
        return view('frontend.pages.become-instructor', compact('withdrawMethods', 'instructorRequestSetting'));
    }

    function store(BecomeInstructorStoreRequest $request): RedirectResponse
    {
        $instructorRequest = InstructorRequest::updateOrCreate(
            ['user_id' => auth('web')->user()->id],
            [
                'status' => 'pending',
                'payout_account' => $request->payout_account,
                'payout_information' => $request->payout_information,
                'extra_information' => $request->extra_information,
            ]
        );

        if($request->has('certificate')) {
            $filePath = file_upload($request->certificate);
            $instructorRequest->certificate = $filePath;
            $instructorRequest->save();
        }

        if($request->has('identity_scan')) {
            $filePath = file_upload($request->identity_scan);
            $instructorRequest->identity_scan = $filePath;
            $instructorRequest->save();
        }

        return redirect()->route('student.dashboard')->with([
            'success' => __('Instructor request submitted successfully we will let you know when your account is approved'),
            'alert-type' => 'success'
        ]);
    }

    function checkIfApproveInstructor(): bool
    {
        return instructorStatus() == UserStatus::APPROVED->value;
    }
}

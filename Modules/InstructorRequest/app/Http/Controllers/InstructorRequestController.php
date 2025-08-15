<?php

namespace Modules\InstructorRequest\app\Http\Controllers;

use App\Enums\RedirectType;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\RedirectHelperTrait;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\InstructorRequest\app\Models\InstructorRequest;
use Modules\InstructorRequest\app\Services\EmailService;

class InstructorRequestController extends Controller
{
    use RedirectHelperTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        checkAdminHasPermissionAndThrowException('instructor.request.list');
        $query = InstructorRequest::query();
        $query->with(['user']);
        $query->when($request->keyword, function($q) use ($request) {
            $q->whereHas('user', function($q) use ($request) {
                $q->where('name', 'like', "%{$request->keyword}%")
                    ->orWhere('email', 'like', "%{$request->keyword}%")
                    ->orWhere('phone', 'like', "%{$request->keyword}%");
            });
        });
        $query->when($request->status, fn ($q) => $q->where('status', $request->status));
        $orderBy = $request->order_by == 1 ? 'asc' : 'desc';
        $instructorRequests = $request->get('par-page') == 'all' ?
            $query->orderBy('id', $orderBy)->get() :
            $query->orderBy('id', $orderBy)->paginate($request->get('par-page') ?? null)->withQueryString();
        return view('instructorrequest::instructor-request.index', compact('instructorRequests'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        checkAdminHasPermissionAndThrowException('instructor.request.list');

        $instructorRequest = InstructorRequest::find($id);
        $user = User::where('id', $instructorRequest->user_id)->first();
        return view('instructorrequest::instructor-request.edit', compact('user', 'instructorRequest'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        checkAdminHasPermissionAndThrowException('instructor.request.list');

        $instructorRequest = InstructorRequest::find($id);
        $instructorRequest->status = $request->status;
        $instructorRequest->save();

        $user = User::where('id', $instructorRequest->user_id)->first();
        $user->role = 'instructor';
        $user->save();

        (new EmailService)->handleInstructorRequestStatusMailSending([
            'user_email' => $instructorRequest->user->email,
            'user_name' => $instructorRequest->user->name,
            'status' => $instructorRequest->status
        ]);

        return $this->redirectWithMessage(RedirectType::UPDATE->value, 'admin.instructor-request.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        checkAdminHasPermissionAndThrowException('instructor.request.list');

        $request = InstructorRequest::findOrFail($id);
        $request->delete();

        return $this->redirectWithMessage(RedirectType::DELETE->value, 'admin.instructor-request.index');
    }
}

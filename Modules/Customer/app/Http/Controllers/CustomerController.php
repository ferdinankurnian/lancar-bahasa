<?php

namespace Modules\Customer\app\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\User;
use App\Models\UserEducation;
use App\Models\UserExperience;
use App\Services\MailSenderService;
use App\Traits\GetGlobalInformationTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Modules\Customer\app\Jobs\SendBulkEmailToUser;
use Modules\Customer\app\Jobs\SendUserBannedMailJob;
use Modules\Customer\app\Models\BannedHistory;
use Modules\Location\app\Models\City;
use Modules\Location\app\Models\State;

class CustomerController extends Controller
{
    use GetGlobalInformationTrait;

    public function index(Request $request)
    {
        checkAdminHasPermissionAndThrowException('customer.view');

        $query = User::query();

        $query->when($request->filled('keyword'), function ($q) use ($request) {
            $q->where('name', 'like', '%' . $request->keyword . '%')
                ->orWhere('email', 'like', '%' . $request->keyword . '%')
                ->orWhere('phone', 'like', '%' . $request->keyword . '%')
                ->orWhere('address', 'like', '%' . $request->keyword . '%');
        });

        $query->when($request->filled('verified'), function ($q) use ($request) {
            $q->where(function ($query) use ($request) {
                if ($request->verified == 1) {
                    $query->whereNotNull('email_verified_at');
                } elseif ($request->verified == 0) {
                    $query->whereNull('email_verified_at');
                }
            });
        });

        $query->when($request->filled('banned'), function ($q) use ($request) {
            $q->where(function ($query) use ($request) {
                if ($request->banned == 1) {
                    $query->where('is_banned', 'yes');
                } elseif ($request->banned == 0) {
                    $query->where('is_banned', 'no');
                }
            });
        });
        $query->where('role', 'student');
        $orderBy = $request->filled('order_by') && $request->order_by == 1 ? 'asc' : 'desc';

        if ($request->filled('par-page')) {
            $users = $request->get('par-page') == 'all' ? $query->orderBy('id', $orderBy)->get() : $query->orderBy('id', $orderBy)->paginate($request->get('par-page'))->withQueryString();
        } else {
            $users = $query->orderBy('id', $orderBy)->paginate()->withQueryString();
        }

        return view('customer::all_customer')->with([
            'users' => $users,
        ]);
    }

    function allInstructors(Request $request)
    {
        checkAdminHasPermissionAndThrowException('customer.view');

        $query = User::query();

        $query->when($request->filled('keyword'), function ($q) use ($request) {
            $q->where('name', 'like', '%' . $request->keyword . '%')
                ->orWhere('email', 'like', '%' . $request->keyword . '%')
                ->orWhere('phone', 'like', '%' . $request->keyword . '%')
                ->orWhere('address', 'like', '%' . $request->keyword . '%');
        });

        $query->when($request->filled('verified'), function ($q) use ($request) {
            $q->where(function ($query) use ($request) {
                if ($request->verified == 1) {
                    $query->whereNotNull('email_verified_at');
                } elseif ($request->verified == 0) {
                    $query->whereNull('email_verified_at');
                }
            });
        });

        $query->when($request->filled('banned'), function ($q) use ($request) {
            $q->where(function ($query) use ($request) {
                if ($request->banned == 1) {
                    $query->where('is_banned', 'yes');
                } elseif ($request->banned == 0) {
                    $query->where('is_banned', 'no');
                }
            });
        });
        $query->where('role', 'instructor');
        $orderBy = $request->filled('order_by') && $request->order_by == 1 ? 'asc' : 'desc';

        if ($request->filled('par-page')) {
            $users = $request->get('par-page') == 'all' ? $query->orderBy('id', $orderBy)->get() : $query->orderBy('id', $orderBy)->paginate($request->get('par-page'))->withQueryString();
        } else {
            $users = $query->orderBy('id', $orderBy)->paginate()->withQueryString();
        }

        return view('customer::all_instructor')->with([
            'users' => $users,
        ]);
    }

    public function active_customer(Request $request)
    {
        checkAdminHasPermissionAndThrowException('customer.view');

        $query = User::query();
        $query->where(['status' => 'active', 'is_banned' => 'no'])->where('email_verified_at', '!=', null);

        $query->when($request->filled('keyword'), function ($q) use ($request) {
            $q->where('name', 'like', '%' . $request->keyword . '%')
                ->orWhere('email', 'like', '%' . $request->keyword . '%')
                ->orWhere('phone', 'like', '%' . $request->keyword . '%')
                ->orWhere('address', 'like', '%' . $request->keyword . '%');
        });

        $orderBy = $request->filled('order_by') && $request->order_by == 1 ? 'asc' : 'desc';

        if ($request->filled('par-page')) {
            $users = $request->get('par-page') == 'all' ? $query->orderBy('id', $orderBy)->get() : $query->orderBy('id', $orderBy)->paginate($request->get('par-page'))->withQueryString();
        } else {
            $users = $query->orderBy('id', $orderBy)->paginate()->withQueryString();
        }

        return view('customer::active_customer')->with([
            'users' => $users,
        ]);
    }

    public function non_verified_customers(Request $request)
    {
        checkAdminHasPermissionAndThrowException('customer.view');

        $query = User::query();
        $query->where('email_verified_at', null);

        $query->when($request->filled('keyword'), function ($q) use ($request) {
            $q->where('name', 'like', '%' . $request->keyword . '%')
                ->orWhere('email', 'like', '%' . $request->keyword . '%')
                ->orWhere('phone', 'like', '%' . $request->keyword . '%')
                ->orWhere('address', 'like', '%' . $request->keyword . '%');
        });
        $query->when($request->filled('banned'), function ($q) use ($request) {
            $q->where(function ($query) use ($request) {
                if ($request->banned == 1) {
                    $query->where('is_banned', 'yes');
                } elseif ($request->banned == 0) {
                    $query->where('is_banned', 'no');
                }
            });
        });
        $orderBy = $request->filled('order_by') && $request->order_by == 1 ? 'asc' : 'desc';

        if ($request->filled('par-page')) {
            $users = $request->get('par-page') == 'all' ? $query->orderBy('id', $orderBy)->get() : $query->orderBy('id', $orderBy)->paginate($request->get('par-page'))->withQueryString();
        } else {
            $users = $query->orderBy('id', $orderBy)->paginate()->withQueryString();
        }

        return view('customer::non_verified_customer')->with([
            'users' => $users,
        ]);
    }

    public function banned_customers(Request $request)
    {
        checkAdminHasPermissionAndThrowException('customer.view');

        $query = User::query();
        $query->where('is_banned', 'yes');

        $query->when($request->filled('keyword'), function ($q) use ($request) {
            $q->where('name', 'like', '%' . $request->keyword . '%')
                ->orWhere('email', 'like', '%' . $request->keyword . '%')
                ->orWhere('phone', 'like', '%' . $request->keyword . '%')
                ->orWhere('address', 'like', '%' . $request->keyword . '%');
        });

        $query->when($request->filled('verified'), function ($q) use ($request) {
            $q->where(function ($query) use ($request) {
                if ($request->verified == 1) {
                    $query->whereNotNull('email_verified_at');
                } elseif ($request->verified == 0) {
                    $query->whereNull('email_verified_at');
                }
            });
        });

        $orderBy = $request->filled('order_by') && $request->order_by == 1 ? 'asc' : 'desc';

        if ($request->filled('par-page')) {
            $users = $request->get('par-page') == 'all' ? $query->orderBy('id', $orderBy)->get() : $query->orderBy('id', $orderBy)->paginate($request->get('par-page'))->withQueryString();
        } else {
            $users = $query->orderBy('id', $orderBy)->paginate()->withQueryString();
        }

        return view('customer::banned_customer')->with([
            'users' => $users,
        ]);
    }

    public function show($id)
    {
        checkAdminHasPermissionAndThrowException('customer.view');

        $user = User::findOrFail($id);
        $experiences = UserExperience::where('user_id', $user->id)->get();
        $educations = UserEducation::where('user_id', $user->id)->get();
        $banned_histories = BannedHistory::where('user_id', $id)->orderBy('id', 'desc')->get();
        $states = State::where(['country_id' => $user->country_id, 'status' => 1])->get();
        $cities = City::where(['state_id' => $user->state_id, 'status' => 1])->get();

        return view('customer::customer_show')->with([
            'user' => $user,
            'banned_histories' => $banned_histories,
            'experiences' => $experiences,
            'educations' => $educations,
            'states' => $states,
            'cities' => $cities
        ]);
    }

    public function update(Request $request, $id)
    {
        checkAdminHasPermissionAndThrowException('customer.update');

        $rules = [
            'name' => 'required',
            'email' => ['required', 'email', 'max:255']
        ];
        $customMessages = [
            'name.required' => __('Name is required'),
            'address.required' => __('Address is required'),
            'email.required' => __('Email is required'),
            'email.email' => __('Email is not valid'),
            'email.max' => __('Email maximum 255 character'),
        ];
        $request->validate($rules, $customMessages);

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->age = $request->age;
        $user->gender = $request->gender;

        $user->save();

        $notification = __('Updated Successfully');
        $notification = ['messege' => $notification, 'alert-type' => 'success'];

        return redirect()->back()->with($notification);
    }

    function bioUpdate(Request $request, $id)
    {
        $rules = [
            'designation' => ['required', 'string', 'max:255'],
            'bio' => ['required', 'string', 'max:2000'],
            'short_bio' => ['required', 'string', 'max:300'],
        ];
        $messages = [
            'designation.required' => __('The designation field is required'),
            'designation.string' => __('The designation must be a string'),
            'designation.max' => __('The designation may not be greater than 255 characters.'),
            'bio.required' => __('The bio field is required'),
            'bio.string' => __('The bio must be a string'),
            'bio.max' => __('The bio may not be greater than 2000 characters.'),
            'short_bio.required' => __('The short bio field is required'),
            'short_bio.string' => __('The short bio must be a string'),
            'short_bio.max' => __('The short bio may not be greater than 300 characters.'),
        ];

        $this->validate($request, $rules, $messages);

        $user = User::findOrFail($id);
        $user->job_title = $request->designation;
        $user->bio = $request->bio;
        $user->short_bio = $request->short_bio;
        $user->save();

        $notification = __('Updated Successfully');
        $notification = ['messege' => $notification, 'alert-type' => 'success'];

        return redirect()->back()->with($notification);
    }

    function experienceModal(Request $request, $id)
    {
        $user = User::find($id);
        return view('customer::modals.experience-modal', compact('user'))->render();
    }

    function experienceStore(Request $request, $id)
    {
        $rules = [
            'company' => ['required', 'string', 'max:255'],
            'position' => ['required', 'string', 'max:255'],
            'start_date' => ['required', 'date'],
            'end_date' => ['nullable', 'date'],
            'current' => ['boolean']
        ];

        $messages = [
            'company.required' => __('The company field is required'),
            'company.string' => __('The company must be a string'),
            'company.max' => __('The company may not be greater than 255 characters.'),
            'position.required' => __('The position field is required'),
            'position.string' => __('The position must be a string'),
            'position.max' => __('The position may not be greater than 255 characters.'),
            'start_date.required' => __('The start date field is required'),
            'start_date.date' => __('The start date must be a date'),
            'end_date.date' => __('The end date must be a date'),
            'current.boolean' => __('The current field must be a boolean'),
        ];

        $this->validate($request, $rules, $messages);
        $experience = new UserExperience();
        $experience->user_id = $id;
        $experience->company = $request->company;
        $experience->position = $request->position;
        $experience->start_date = $request->start_date;
        $experience->end_date = $request->end_date;
        $experience->current = $request->current;
        $experience->save();

        $notification = __('Created Successfully');
        $notification = ['messege' => $notification, 'alert-type' => 'success'];

        return redirect()->back()->with($notification);
    }

    function editExperienceModal(Request $request, $id) {
        $experience = UserExperience::find($id);
        return view('customer::modals.edit-experience-modal', compact('experience'))->render();
    }

    function experienceUpdate(Request $request, $id) {
        $rules = [
            'company' => ['required', 'string', 'max:255'],
            'position' => ['required', 'string', 'max:255'],
            'start_date' => ['required', 'date'],
            'end_date' => ['nullable', 'date'],
            'current' => ['boolean']
        ];

        $messages = [
            'company.required' => __('The company field is required'),
            'company.string' => __('The company must be a string'),
            'company.max' => __('The company may not be greater than 255 characters.'),
            'position.required' => __('The position field is required'),
            'position.string' => __('The position must be a string'),
            'position.max' => __('The position may not be greater than 255 characters.'),
            'start_date.required' => __('The start date field is required'),
            'start_date.date' => __('The start date must be a date'),
            'end_date.date' => __('The end date must be a date'),
            'current.boolean' => __('The current field must be a boolean'),
        ];

        $this->validate($request, $rules, $messages); 
        $experience = UserExperience::whereId($id)->firstOrFail();
        $experience->company = $request->company;
        $experience->position = $request->position;
        $experience->start_date = $request->start_date;
        $experience->end_date = $request->end_date;
        $experience->current = $request->current;
        $experience->save();

        $notification = __('Update Successfully');
        $notification = ['messege' => $notification, 'alert-type' => 'success'];

        return redirect()->back()->with($notification);
    }

    function experienceDestroy($id) {
        $experience = UserExperience::whereId($id)->firstOrFail();
        $experience->delete();
        
        $notification = __('Deleted Successfully');
        $notification = ['messege' => $notification, 'alert-type' => 'success'];

        return redirect()->back()->with($notification);
    }

    function educationModal(Request $request, $id)
    {
        $user = User::find($id);
        return view('customer::modals.add-education-modal', compact('user'))->render();
    }

    function educationStore(Request $request, $id)
    {
        $rules = [
            'organization' => ['required', 'max:255', 'string'],
            'degree' => ['required', 'max:255', 'string'],
            'start_date' => ['required', 'date'],
            'end_date' => ['nullable', 'date'],
        ];
        $messages = [
            
            'organization.required' => __('The organization field is required.'),
            'organization.max' => __('The organization field must not be greater than 255 characters.'),
            'organization.string' => __('The organization field must be a string.'),

            'degree.required' => __('The degree field is required.'),
            'degree.max' => __('The degree field must not be greater than 255 characters.'),
            'degree.string' => __('The degree field must be a string.'),

            'start_date.required' => __('The start date field is required.'),
            'start_date.date' => __('The start date field must be a valid date.'),

            'end_date.required' => __('The end date field is required.'),
            'end_date.date' => __('The end date field must be a valid date.'),
        ];

        $this->validate($request, $rules, $messages);

        $education = new UserEducation();
        $education->user_id = $id;
        $education->organization = $request->organization; 
        $education->degree = $request->degree; 
        $education->start_date = $request->start_date; 
        $education->end_date = $request->end_date; 
        $education->current = $request->current; 
        $education->save();

        $notification = __('Create Successfully');
        $notification = ['messege' => $notification, 'alert-type' => 'success'];

        return redirect()->back()->with($notification);
    }

    function editEducationModal(Request $request, $id) {
        $education = UserEducation::find($id); 
        return view('customer::modals.edit-education-modal', compact('education'))->render(); 
    }

    function educationUpdate(Request $request, $id) {
       
        $rules = [
            'organization' => ['required', 'max:255', 'string'],
            'degree' => ['required', 'max:255', 'string'],
            'start_date' => ['required', 'date'],
            'end_date' => ['nullable', 'date'],
        ];
        $messages = [
            
            'organization.required' => __('The organization field is required.'),
            'organization.max' => __('The organization field must not be greater than 255 characters.'),
            'organization.string' => __('The organization field must be a string.'),

            'degree.required' => __('The degree field is required.'),
            'degree.max' => __('The degree field must not be greater than 255 characters.'),
            'degree.string' => __('The degree field must be a string.'),

            'start_date.required' => __('The start date field is required.'),
            'start_date.date' => __('The start date field must be a valid date.'),

            'end_date.required' => __('The end date field is required.'),
            'end_date.date' => __('The end date field must be a valid date.'),
        ];

        $this->validate($request, $rules, $messages);
        $education = UserEducation::whereId($id)->firstOrFail();
        $education->organization = $request->organization; 
        $education->degree = $request->degree; 
        $education->start_date = $request->start_date; 
        $education->end_date = $request->end_date; 
        $education->current = $request->current;
        $education->save();

        $notification = __('Update Successfully');
        $notification = ['messege' => $notification, 'alert-type' => 'success'];

        return redirect()->back()->with($notification);
    }

    function educationDestroy($id) {
        $education = UserEducation::whereId($id)->firstOrFail();
        $education->delete();
        
        $notification = __('Deleted Successfully');
        $notification = ['messege' => $notification, 'alert-type' => 'success'];

        return redirect()->back()->with($notification);
    }

    function locationUpdate(Request $request, $id) {
        $request->validate([
            'country' => ['required', 'integer', 'exists:countries,id'],
            'state' => ['nullable', 'max:255'],
            'city' => ['nullable', 'max:255'],
            'address' => ['nullable', 'string', 'max:255']
        ],[
            'country.required' => __('You must select a country.'),
            'country.integer' => __('Country ID must be an integer.'),
            'country.exists' => __('The selected country is invalid.'),
            'state.integer' => __('State ID must be an integer.'),
            'state.exists' => __('The selected state is invalid.'),
            'city.integer' => __('City ID must be an integer.'),
            'city.exists' => __('The selected city is invalid.'),
            'address.string' => __('The address must be a string.'),
            'address.max' => __('The address may not be greater than 255 characters.'),
        ]);

        $user = User::findOrFail($id);
        $user->address = $request->address;
        $user->city = $request->city;
        $user->state = $request->state;
        $user->country_id = $request->country;
        $user->save(); 

        $notification = __('Updated Successfully');
        $notification = ['messege' => $notification, 'alert-type' => 'success'];

        return redirect()->back()->with($notification);
    }

    function socialUpdate(Request $request, $id) {
        $rules = [
            'facebook' => ['nullable', 'string', 'max:255'],
            'twitter' => ['nullable', 'string', 'max:255'],
            'linkedin' => ['nullable', 'string', 'max:255'],
            'website' => ['nullable', 'string', 'max:255'],
            'github' => ['nullable', 'string', 'max:255'],
        ];
        $messages = [
            'facebook.string' => __('The facebook must be a string.'),
            'facebook.max' => __('The facebook may not be greater than 255 characters.'),
            'twitter.string' => __('The twitter must be a string.'),
            'twitter.max' => __('The twitter may not be greater than 255 characters.'),
            'linkedin.string' => __('The linkedin must be a string.'),
            'linkedin.max' => __('The linkedin may not be greater than 255 characters.'),
            'website.string' => __('The website must be a string.'),
            'website.max' => __('The website may not be greater than 255 characters.'),
            'github.string' => __('The github must be a string.'),
            'github.max' => __('The github may not be greater than 255 characters.'),
        ];

        $this->validate($request, $rules, $messages);

        $user = User::findOrFail($id);
        $user->facebook = $request->facebook;
        $user->twitter = $request->twitter;
        $user->website = $request->website;
        $user->linkedin = $request->linkedin;
        $user->github = $request->github;
        $user->save(); 

        $notification = __('Updated Successfully');
        $notification = ['messege' => $notification, 'alert-type' => 'success'];

        return redirect()->back()->with($notification);
    }

    public function password_change(Request $request, $id)
    {
        checkAdminHasPermissionAndThrowException('customer.update');

        $rules = [
            'password' => 'required|min:4|confirmed',
        ];
        $customMessages = [
            'password.required' => __('Password is required'),
            'password.min' => __('Password minimum 4 character'),
            'password.confirmed' => __('Confirm password does not match'),
        ];
        $this->validate($request, $rules, $customMessages);

        $user = User::findOrFail($id);

        $user->password = Hash::make($request->password);
        $user->save();

        $notification = __('Password change successfully');
        $notification = ['messege' => $notification, 'alert-type' => 'success'];

        return redirect()->back()->with($notification);
    }

    public function send_banned_request(Request $request, $id)
    {
        checkAdminHasPermissionAndThrowException('customer.update');

        $rules = [
            'subject' => 'required|max:255',
            'description' => 'required',
        ];
        $customMessages = [
            'subject.required' => __('Subject is required'),
            'description.required' => __('Description is required'),
        ];

        $this->validate($request, $rules, $customMessages);

        $user = User::findOrFail($id);
        if ($user->is_banned == 'yes') {
            $user->is_banned = 'no';
            $user->save();

            $banned = new BannedHistory();
            $banned->user_id = $id;
            $banned->subject = $request->subject;
            $banned->reasone = 'for_unbanned';
            $banned->description = $request->description;
            $banned->save();
        } else {
            $user->is_banned = 'yes';
            $user->save();

            $banned = new BannedHistory();
            $banned->user_id = $id;
            $banned->subject = $request->subject;
            $banned->reasone = 'for_banned';
            $banned->description = $request->description;
            $banned->save();
        }

        (new MailSenderService)->SendUserBannedMailFromTrait($request->description, $request->subject, $user);

        $notification = __('Banned request successfully');
        $notification = ['messege' => $notification, 'alert-type' => 'success'];

        return redirect()->back()->with($notification);
    }

    public function send_verify_request(Request $request, $id)
    {

        $user = User::findOrFail($id);
        $user->verification_token = Str::random(100);
        $user->save();

        (new MailSenderService)->sendVerifyMailToUserFromTrait('single_user', $user);

        $notification = __('A varification link has been send to user mail');
        $notification = ['messege' => $notification, 'alert-type' => 'success'];

        return redirect()->back()->with($notification);
    }

    public function send_verify_request_to_all(Request $request)
    {

        (new MailSenderService)->sendVerifyMailToUserFromTrait('all_user');

        $notification = __('A varification link has been send to user mail');
        $notification = ['messege' => $notification, 'alert-type' => 'success'];

        return redirect()->back()->with($notification);
    }

    public function send_mail_to_customer(Request $request, $id)
    {
        $rules = [
            'subject' => 'required|max:255',
            'description' => 'required',
        ];
        $customMessages = [
            'subject.required' => __('Subject is required'),
            'description.required' => __('Description is required'),
        ];

        $this->validate($request, $rules, $customMessages);

        $user = User::findOrFail($id);

        (new MailSenderService)->sendMailToUserFromTrait($request->subject, $request->description, 'single_user', $user);

        $notification = __('Mail send to customer successfully');
        $notification = ['messege' => $notification, 'alert-type' => 'success'];

        return redirect()->back()->with($notification);
    }

    public function send_bulk_mail()
    {
        checkAdminHasPermissionAndThrowException('customer.bulk.mail');

        return view('customer::send_bulk_mail');
    }

    public function send_bulk_mail_to_all(Request $request)
    {
        checkAdminHasPermissionAndThrowException('customer.bulk.mail');

        $rules = [
            'subject' => 'required|max:255',
            'description' => 'required',
        ];

        $customMessages = [
            'subject.required' => __('Subject is required'),
            'description.required' => __('Description is required'),
        ];

        $this->validate($request, $rules, $customMessages);

        (new MailSenderService)->sendMailToUserFromTrait($request->subject, $request->description, 'all_user');

        $notification = __('Mail send to customer successfully');
        $notification = ['messege' => $notification, 'alert-type' => 'success'];

        return redirect()->back()->with($notification);
    }

    public function destroy($id)
    {
        checkAdminHasPermissionAndThrowException('customer.delete');

        $user = User::findOrFail($id);

        // prevent delete instructor if exists course
        if ($user->role == 'instructor') {
            $coursesExist = Course::where('instructor_id', $user->id)->exists();
            if ($coursesExist) {
                $notification = __('Instructor can not be deleted. Instructor has courses');
                $notification = ['messege' => $notification, 'alert-type' => 'error'];
                return redirect()->back()->with($notification);
            }
        }

        // prevent delete instructor if exists course
        if ($user->role == 'student') {
            if ($user->orders()->count() > 0) {
                return redirect()->back()->with(['alert-type' => 'error', 'messege' => __('A student cannot be deleted because he has purchased course.')]);
            }
        }

        if ($user->image) {
            if (File::exists(public_path($user->image))) {
                unlink(public_path($user->image));
            }
        }

        $user->delete();

        $notification = __('User deleted successfully');
        $notification = ['messege' => $notification, 'alert-type' => 'success'];

        return redirect()->back()->with($notification);
    }
}

<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\UserStatus;
use App\Models\JitsiSetting;
use Laravel\Sanctum\HasApiTokens;
use Modules\Order\app\Models\Order;
use Illuminate\Notifications\Notifiable;
use Modules\LiveChat\app\Models\Message;
use Modules\Location\app\Models\Country;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Modules\InstructorRequest\app\Models\InstructorRequest;

class User extends Authenticatable {
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'role',
        'name',
        'email',
        'password',
        'status',
        'is_banned',
        'verification_token',
        'forget_password_token',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
    ];

    public function messagesSent() {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function messagesReceived() {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    public function contactUsers() {
        return User::whereIn('id', $this->messagesSent()->pluck('receiver_id'))
            ->orWhereIn('id', $this->messagesReceived()->pluck('sender_id'))
            ->get();
    }

    public function contactUsersWithUnseenMessages() {
        $contactUsers = User::whereIn('id', $this->messagesSent()->pluck('receiver_id'))
            ->orWhereIn('id', $this->messagesReceived()->pluck('sender_id'))
            ->select('id', 'name', 'email', 'image')
            ->get();

        $contactUsersWithUnseenMessages = [];

        foreach ($contactUsers as $contactUser) {
            $unseenMessagesCount = Message::where('sender_id', $contactUser->id)
                ->where('receiver_id', $this->id)
                ->where('seen', 'no')
                ->count();

            $lastMessage = Message::where(function ($query) use ($contactUser) {
                $query->where('sender_id', $this->id)->where('receiver_id', $contactUser->id);
            })->orWhere(function ($query) use ($contactUser) {
                $query->where('sender_id', $contactUser->id)->where('receiver_id', $this->id);
            })->latest('created_at')->first();

            $contactUsersWithUnseenMessages[] = (object) [
                'id'           => $contactUser->id,
                'name'         => $contactUser->name,
                'email'        => $contactUser->email,
                'image'        => $contactUser->image,
                'new_message'  => $unseenMessagesCount,
                'last_message' => $lastMessage->created_at,
            ];
        }

        usort($contactUsersWithUnseenMessages, function ($a, $b) {
            return $b->last_message <=> $a->last_message;
        });

        return $contactUsersWithUnseenMessages;
    }

    public function scopeActive($query) {
        return $query->where('status', UserStatus::ACTIVE);
    }

    public function scopeInactive($query) {
        return $query->where('status', UserStatus::DEACTIVE);
    }

    public function scopeBanned($query) {
        return $query->where('is_banned', UserStatus::BANNED);
    }

    public function scopeUnbanned($query) {
        return $query->where('is_banned', UserStatus::UNBANNED);
    }

    public function socialite() {
        return $this->hasMany(SocialiteCredential::class, 'user_id');
    }

    function instructorInfo(): HasOne {
        return $this->hasOne(InstructorRequest::class, 'user_id', 'id');
    }

    public function courses() {
        return $this->hasMany(Course::class, 'instructor_id');
    }

    function country(): BelongsTo {
        return $this->belongsTo(Country::class, 'country_id');
    }
    function orders(): HasMany {
        return $this->hasMany(Order::class, 'buyer_id', 'id');
    }
    function zoom_credential(): HasOne {
        return $this->hasOne(ZoomCredential::class, 'instructor_id', 'id');
    }
    function jitsi_credential(): HasOne {
        return $this->hasOne(JitsiSetting::class, 'instructor_id', 'id');
    }

    /**
     * Boot the model.
     */
    protected static function boot() {
        parent::boot();

        static::deleting(function ($user) {
            // Delete related instructor request
            $user->instructorInfo()->delete();
        });
    }
}

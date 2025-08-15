<?php

namespace App\Console\Commands;

use App\Models\CourseLiveClass;
use App\Models\User;
use App\Services\MailSenderService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Modules\Order\app\Models\Enrollment;

class PreNotification extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'prenotification:live';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Live Class Pre-Notification';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle() {
        $now = Carbon::now();
        $futureTime = $now->copy()->addMinutes(cache()->get('setting')?->live_mail_send ?? 5);

        $liveClasses = CourseLiveClass::select('lesson_id', 'start_time', 'join_url')
            ->with([
                'lesson:id,instructor_id,course_id,title',
                'lesson.course:id,title',
            ])
            ->whereBetween('start_time', [$now, $futureTime])
            ->get();

        foreach ($liveClasses as $liveClass) {
            // Fetch the enrolled users for the course
            $user_ids = Enrollment::where('course_id', $liveClass->lesson->course_id)
                ->pluck('user_id')
                ->toArray();

            $users = User::select('name', 'email')->whereIn('id', $user_ids)->get();

            // Prepare the data for each live class
            $data = (object) [
                'course'     => $liveClass->lesson->course->title,
                'lesson'     => $liveClass->lesson->title,
                'start_time' => formattedDateTime($liveClass->start_time),
                'join_url'   => $liveClass->join_url,
            ];

            (new MailSenderService)->sendLiveClassNotificationMailTrait($users, $data);
        }

    }
}

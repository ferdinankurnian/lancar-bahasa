<?php

namespace Modules\GlobalSetting\database\seeders;

use Illuminate\Database\Seeder;
use Modules\GlobalSetting\app\Models\EmailTemplate;

class EmailTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $templates = [
            [
                'name' => 'password_reset',
                'subject' => 'Password Reset',
                'message' => '<p>Dear {{user_name}},</p>
                <p>Do you want to reset your password? Please Click the following link and Reset Your Password.</p>',
            ],
            [
                'name' => 'contact_mail',
                'subject' => 'Contact Email',
                'message' => '<p>Hello there,</p>
                <p>&nbsp;Mr. {{name}} has sent a new message. you can see the message details below.&nbsp;</p>
                <p>Email: {{email}}</p>
                <p>Phone: {{phone}}</p>
                <p>Subject: {{subject}}</p>
                <p>Message: {{message}}</p>',
            ],
            [
                'name' => 'subscribe_notification',
                'subject' => 'Subscribe Notification',
                'message' => '<p>Hi there, Congratulations! Your Subscription has been created successfully. Please Click the following link and Verified Your Subscription. If you will not approve this link, you can not get any newsletter from us.</p>',
            ],

            [
                'name' => 'user_verification',
                'subject' => 'User Verification',
                'message' => '<p>Dear {{user_name}},</p>
                <p>Congratulations! Your Account has been created successfully. Please Click the following link and Active your Account.</p>',
            ],

            [
                'name' => 'approved_refund',
                'subject' => 'Refund Request Approval',
                'message' => '<p>Dear {{user_name}},</p>
                <p>We are happy to say that, we have send {{refund_amount}} USD to your provided bank information. </p>',
            ],

            [
                'name' => 'new_refund',
                'subject' => 'New Refund Request',
                'message' => '<p>Hello websolutionus, </p>

                <p>Mr. {{user_name}} has send a new refund request to you.</p>',
            ],

            [
                'name' => 'pending_wallet_payment',
                'subject' => 'Wallet Payment Approval',
                'message' => '<p>Hello {{user_name}},</p>
                <p>We have received your wallet payment request. we find your payment to our bank account.</p>
                <p>Thanks &amp; Regards</p>',
            ],

            [
                'name' => 'approved_withdraw',
                'subject' => 'Withdraw Request Approval',
                'message' => '<p>Dear {{user_name}},</p>
                <p>We are happy to say that, we have send a withdraw amount to your provided bank information.</p>
                <p>Thanks &amp; Regards</p>
                <p>WebSolutionUs</p>',
            ],
            [
                'name' => 'rejected_withdraw',
                'subject' => 'Withdraw Request Rejected',
                'message' => '<p>Dear {{user_name}},</p>
                <p> your withdraw request has been rejected.</p>
                <p>Thanks &amp; Regards</p>
                <p>WebSolutionUs</p>',
            ],
            [
                'name' => 'pending_withdraw',
                'subject' => 'Withdraw Request Pending',
                'message' => '<p>Dear {{user_name}},</p>
                <p> your withdraw request is waiting for approval.</p>
                <p>Thanks &amp; Regards</p>
                <p>WebSolutionUs</p>',
            ],
            [
                'name' => 'instructor_request_approved',
                'subject' => 'Instructor Request Approval',
                'message' => '<p>Dear {{user_name}},</p>
                <p>you are now approved as an instructor.</p>',
            ],
            [
                'name' => 'instructor_request_rejected',
                'subject' => 'Instructor Request Rejected',
                'message' => '<p>Dear {{user_name}},</p>
                <p>your request has been rejected. please resubmit your request with proper document. or contact us.</p>',
            ],
            [
                'name' => 'instructor_request_pending',
                'subject' => 'Instructor Request is waiting for approval',
                'message' => '<p>Dear {{user_name}},</p>
                <p>your request for become an instructor is waiting for approval. please wait. we will send you an email when your request is approved.</p>',
            ],
            [
                'name' => 'instructor_quick_contact',
                'subject' => 'Mail for instructor contact form',
                'message' => '<p>Name: {{name}}</p>
                <p>Email: {{email}}</p>
                <p>Subject: {{subject}}</p>
                <p>{{message}}</p>',
            ],
            [
                'name' => 'order_completed',
                'subject' => 'Your order has been placed',
                'message' => '<p>HI, {{name}}</p>
                <p>product id: {{order_id}}</p>
                <p>paid amount: {{paid_amount}}</p>
                <p>payment method: {{payment_method}}</p>',
            ],
            [
                'name' => 'qna_reply_mail',
                'subject' => 'QNA Replay mail',
                'message' => '<p>Hi {{user_name}}, your instructor has replied to your question. Please see the answer below:</p><p>Course: {{course}}</p><p>Lesson: {{lesson}}</p><p>Question: {{question}}</p>',
            ],
            [
                'name' => 'live_class_mail',
                'subject' => 'Live class notification mail',
                'message' => '<p>Hi {{user_name}},</p>
                <p>Your live class is starting at {{start_time}}. Please see the details below:</p>
                <p><strong>Course:</strong> {{course}}</p>
                <p><strong>Lesson:</strong> {{lesson}}</p>
                <p><strong>Meeting Link:</strong> <a href="{{join_url}}">{{join_url}}</a></p>',
            ],
        ];

        EmailTemplate::truncate();
        foreach ($templates as $index => $template) {
            $new_template = new EmailTemplate();
            $new_template->name = $template['name'];
            $new_template->subject = $template['subject'];
            $new_template->message = $template['message'];
            $new_template->save();
        }
    }
}

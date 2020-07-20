<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Exception;

class SendVerificationEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $randNo;
    protected $user;

    /**
     * Create a new job instance.
     *
     * @param $randNo
     * @param $user
     */
    public function __construct($randNo, $user)
    {
        $this->randNo = $randNo;
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $user = $this->user;
            $defaultEmail = config('email.defaultEmail');
            $defaultName = config('email.defaultName');
            $logo = config('email.logo');
            Mail::send('email.email_verification', [
                'key' => $this->randNo,
                'company' => $defaultName,
                'logo' => $logo
            ], function ($message) use ($user, $defaultEmail, $defaultName) {
                $message->to($user->email)->subject(__('Email Verification'))->from(
                    $defaultEmail, $defaultName
                );
            });
        } catch (Exception $exception){
            Log::info($exception->getMessage());
        }
    }
}

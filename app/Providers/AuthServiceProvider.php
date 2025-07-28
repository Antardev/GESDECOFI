<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Mail\ResetPass;
use App\Mail\VerifyEmail as MailVerifyEmail;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Mail;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        VerifyEmail::toMailUsing(function ($notifiable, $verificationUrl) {
            return (new MailMessage)
                ->subject(__('message.verify_email'))
                ->view('email.verification-email', [
                    'verificationUrl' => $verificationUrl
                ]);
        });

        // VerifyEmail::toMailUsing(function ($notifiable, $url) {
        //     // return new VerifyEmail($notifiable, $url);
        //     return Mail::to($notifiable->email)->send(new MailVerifyEmail($notifiable, $url));
        // });

        // ResetPassword::toMailUsing(function ($notifiable, $token) {
        //     // return new VerifyEmail($notifiable, $url);
        //     return Mail::to($notifiable->email)->send(new ResetPass($notifiable, $token));
        // });

        ResetPassword::toMailUsing(function ($notifiable, $token) {
            $emailResetUrl = url(route('password.reset', [
                'token' => $token,
                'email' => $notifiable->getEmailForPasswordReset(),
            ], false));
            return (new MailMessage)
                ->subject(('message.reset_password'))
                ->view('email.reset-password', [
                    'emailResetUrl' => $emailResetUrl
                ]);
        });

    }
}

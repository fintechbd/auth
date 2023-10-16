<?php

namespace Fintech\Auth\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendPasswordResetNotification extends Notification
{
    use Queueable;

    private $data;

    /**
     * Create a new notification instance.
     * @param array <method:string, value:string, status:bool>
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param object $notifiable
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     * @param object $notifiable
     * @return MailMessage
     */
    public function toMail(object $notifiable): MailMessage
    {
        $mailable = (new MailMessage)
            ->line('You recently requested to reset the password for your ' . ucwords(config('app.name')) . ' account.');

        if ($this->data['method'] == 'temporary_password')
            $mailable->lines([
                'Your account existing password as been reset.',
                'We have sent you a completely automated and randomized password as you requested',
                'System or authority does not a plain copy of this information and password will expired within '
                . config('auth.passwords.users.expire') . 'minutes.',
                'Please log into your account using the temporary password, and reset after first successful logged in.',
                'Your account new password will be **' . $this->data['value'] . '**',
            ])
                ->action('Log into Account', $this->data['url'])
                ->line('If you did not request a password reset,
                Please contact system administrator for further action.');

        elseif ($this->data['method'] == 'reset_link')
            $mailable->lines([
                'No changes have been made to your account yet.',
                'System or authority does not a plain copy of this information and reset link will expired within '
                . config('auth.passwords.users.expire') . 'minutes.',
                'Click the button below to proceed.'])
                ->action('Reset Password', $this->data['url'])
                ->line('If you did not request a password reset, no further action is required.');

        elseif ($this->data['method'] == 'otp')
            $mailable->lines([
                'No changes have been made to your account yet.',
                'System or authority does not a plain copy of this information and *One Time Password* verification
                will expired within ' . config('auth.passwords.users.expire') . 'minutes.'
            ])
                ->line("Your account verification OTP is: *{$this->data['value']}*")
                ->line('If you did not request a password reset, no further action is required.');


        return $mailable;
    }

    /**
     * Get the array representation of the notification.
     *
     * @param object $notifiable
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'otp' => $this->data
        ];
    }
}

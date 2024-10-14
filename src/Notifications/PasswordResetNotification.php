<?php

namespace Fintech\Auth\Notifications;

use Fintech\Core\Enums\Auth\PasswordResetOption;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PasswordResetNotification extends Notification implements ShouldQueue
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
        $mailable = (new MailMessage())
            ->line('You recently requested to reset the password for your ' . ucwords(config('app.name')) . ' account.');

        if ($this->data['method'] == PasswordResetOption::TemporaryPassword->value) {
            $mailable = $mailable->lines([
                'We have sent you a completely automated and randomized password as you requested.',
                'Please log into your account using the temporary password afterwards reset after first successful logged in.',
                '',
                'Your account new password will be `' . $this->data['value'] . '`',
            ])
                ->action('Log into Account', $this->data['url'])
                ->line('If you did not request a password reset,
                Please contact system administrator for further action.');
        } elseif ($this->data['method'] == PasswordResetOption::ResetLink->value) {
            $mailable = $mailable->lines([
                '**No changes have been made to your account yet.**',
                'Click the button below to proceed.'])
                ->action('Reset Password', $this->data['url'])
                ->line('If you did not request a password reset, no further action is required.');
        } elseif ($this->data['method'] == PasswordResetOption::Otp->value) {
            $mailable = $mailable->lines([
                '**No changes have been made to your account yet.**',
                "Your account verification OTP is: *{$this->data['value']}*",
                'If you did not request a password reset, no further action is required.'
            ]);
        }

        $mailable = $mailable
            ->lines([
                'This is a automated system generated message authority does not a plain copy of this information and will expired within '
                . config('auth.passwords.users.expire') . ' minutes.',
                'This email and any attachments are confidential and may also be privileged.
            If you are not the intended recipient, please delete all copies and notify the sender immediately.'
            ]);
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

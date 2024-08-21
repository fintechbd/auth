<?php

namespace Fintech\Auth\Notifications;

use Fintech\Core\Enums\Auth\OTPOption;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Laraflow\Sms\Exceptions\DriverNotFoundException;
use Laraflow\Sms\SmsMessage;

class OTPNotification extends Notification
{
    use Queueable;

    private $data;

    /**
     * Create a new notification instance.
     * @param array $data <method:string, value:string, status:bool>
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
        return ((request()->has('mobile')
            ? ['sms']
            : (request()->has('email')))
            ? ['mail']
            : request()->has('user'))
            ? $notifiable->prefer
            : ['database'];
    }

    /**
     * Get the mail representation of the notification.
     * @param object $notifiable
     * @return MailMessage
     */
    public function toMail(object $notifiable): MailMessage
    {
        $mailable = (new MailMessage())
            ->lines([
                'Dear value added customer,',
                ucwords(config('app.name')) . ' system requested information verification of your account.'
            ]);

        if ($this->data['method'] == OTPOption::Link->value) {
            $mailable = $mailable->lines([
                'To verify you account please click on the button below to proceed.'])
                ->action('Verify Account', $this->data['url']);
        } elseif ($this->data['method'] == OTPOption::Otp->value) {
            $mailable = $mailable->line("Your account verification OTP.")
                ->action($this->data['value'], '#');
        }

        $mailable = $mailable
            ->lines([
                'This is a automated system generated verification message, and will expired within '
                . config('auth.passwords.users.expire') . ' minutes.',
                'This email and any attachments are confidential and may also be privileged.'
                . 'If you are not the intended recipient, please delete all copies and notify the sender immediately.'
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

    /**
     */
    public function toSms(object $notifiable): SmsMessage
    {
        return (new SmsMessage)
            ->message('Your LebuPay mobile verification OTP is: ' . $this->data['value']);
    }
}

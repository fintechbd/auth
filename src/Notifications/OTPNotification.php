<?php

namespace Fintech\Auth\Notifications;

use Fintech\Auth\Models\User;
use Fintech\Core\Enums\Auth\OTPOption;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Laraflow\Sms\SmsMessage;

use function decide_sms_from_name;

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
        if (request()->filled('mobile')) {
            return ['sms'];
        }

        if (request()->filled('email')) {
            return ['mail'];
        }

        if (request()->filled('user')) {
            $userModel = config('fintech.auth.user_model', User::class);
            return ($notifiable instanceof $userModel)
                ? $notifiable->prefer ? [$notifiable->prefer] : ['mail']
                : ['database'];
        }

        return ['database'];
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
        return (new SmsMessage())
            ->from(decide_sms_from_name($notifiable->routes['sms']))
            ->message('Your LebuPay mobile verification OTP is: ' . $this->data['value']);
    }
}

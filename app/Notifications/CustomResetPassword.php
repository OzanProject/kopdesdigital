<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CustomResetPassword extends Notification
{
    use Queueable;

    public $token;

    /**
     * Create a new notification instance.
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        // Ensure config is loaded if it hasn't been already (redundant safety)
        if (\Illuminate\Support\Facades\Schema::hasTable('saas_settings')) {
            $settings = \App\Models\SaasSetting::all()->pluck('value', 'key');
            if (isset($settings['mail_host'])) {
                config([
                    'mail.mailers.smtp.host' => $settings['mail_host'],
                    'mail.mailers.smtp.port' => $settings['mail_port'] ?? 587,
                    'mail.mailers.smtp.encryption' => $settings['mail_encryption'] ?? 'tls',
                    'mail.mailers.smtp.username' => $settings['mail_username'],
                    'mail.mailers.smtp.password' => $settings['mail_password'],
                    'mail.from.address' => $settings['mail_from_address'] ?? 'noreply@koperasi.com',
                    'mail.from.name' => $settings['mail_from_name'] ?? 'KopDes Digital',
                ]);
            }
        }

        return (new MailMessage)
            ->subject('Reset Password - KopDes Digital')
            ->greeting('Halo, ' . $notifiable->name . '!')
            ->line('Anda menerima email ini karena kami menerima permintaan reset password untuk akun Anda.')
            ->action('Reset Password Sekarang', url(route('password.reset', [
                'token' => $this->token,
                'email' => $notifiable->getEmailForPasswordReset(),
            ], false)))
            ->line('Link reset password ini akan kadaluarsa dalam 60 menit.')
            ->line('Jika Anda tidak meminta reset password, abaikan email ini.')
            ->salutation('Salam, Tim KopDes Digital');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}

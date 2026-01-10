<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WelcomeTenantNotification extends Notification
{
    use Queueable;

    public $koperasi;
    public $transaction;

    /**
     * Create a new notification instance.
     */
    public function __construct($koperasi, $transaction = null)
    {
        $this->koperasi = $koperasi;
        $this->transaction = $transaction;
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
        $appName = \App\Models\SaasSetting::where('key', 'app_name')->value('value') ?? 'KopDes Digital';
        
        $mail = (new MailMessage)
                    ->subject('Selamat Datang di ' . $appName)
                    ->greeting('Halo ' . $notifiable->name . ',')
                    ->line('Terima kasih telah mendaftarkan koperasi **' . $this->koperasi->nama . '** di platform kami.')
                    ->line('Akun Anda telah berhasil dibuat.');

        if ($this->transaction && $this->transaction->status != 'paid') {
            $mail->line('Status Saat ini: **Menunggu Pembayaran**')
                 ->line('Silakan selesaikan pembayaran invoice Anda untuk mengaktifkan seluruh fitur koperasi.')
                 ->action('Bayar Sekarang', route('payment.show', $this->transaction->order_id));
        } else {
            $mail->line('Status Saat ini: **Aktif**')
                 ->action('Login ke Dashboard', route('dashboard'));
        }

        return $mail->line('Terima kasih telah bergabung bersama kami!');
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

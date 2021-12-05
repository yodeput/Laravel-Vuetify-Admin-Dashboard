<?php

namespace App\Notifications;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Auth\Notifications\ResetPassword;
use Asahasrabuddhe\LaravelMJML\Mail\Mailable;


class MailResetPasswordNotification extends ResetPassword
{
    use Queueable;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
protected $name;


    public function __construct($name, $token)
    {
        $this->name = $name;
        parent::__construct($token);
    }
    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }
    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $link = url( "/#/reset-password/".$this->token );

       return ( new MailMessage )
            ->subject( 'IDFACE - Link Setel Ulang Password' )
            ->line( "Hello $this->name," )
            ->line( "Anda berniat untuk mengatur ulang Password akun di ID FACE." )
            ->action( 'Setel Ulang Password', $link )
            ->line( "Link pada email ini akan jatuh tempo dalam ".config('auth.passwords.users.expire')." menit" )
            ->line( "Apabila anda tidak ada permintaan ini, silahkan hubungu tim support." );
    }
    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}

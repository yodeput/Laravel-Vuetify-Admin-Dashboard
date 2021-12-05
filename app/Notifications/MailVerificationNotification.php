<?php

namespace App\Notifications;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Auth\Notifications\ResetPassword;
use Asahasrabuddhe\LaravelMJML\Mail\Mailable;


class MailVerificationNotification extends VerifyEmail
{
    use Queueable;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
protected $name;
protected $idUser;


    public function __construct($idUser, $name)
    {
        $this->idUser = $idUser;
        $this->name = $name;
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
        $link = url( "/#/verify-email/$this->idUser" );

       return ( new MailMessage )
            ->subject( 'IDFACE - Verifikasi Email' )
            ->line( "Hello $this->name," )
            ->line( "Silahkan klik link dibawah untuk verifikasi email di ID FACE" )
            ->action( 'Verifikasi', $link )
            ->line( "Link pada email ini akan jatuh tempo dalam ".config('auth.passwords.users.expire')." menit" );
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

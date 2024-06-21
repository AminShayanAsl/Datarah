<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegisterMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email)
    {
        session_start();
        $_SESSION['register'] = ['email'=>$email, 'code'=>disposablePassword(), 'code_time'=>strval(time())];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): RegisterMail
    {
        return $this->view('emails/register', ['code'=>$_SESSION['register']['code']])->subject('Datarah Register');
    }
}

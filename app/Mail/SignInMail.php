<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SignInMail extends Mailable
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
        $_SESSION['sign-in'] = ['email'=>$email, 'code'=>disposablePassword(), 'code_time'=>strval(time())];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): SignInMail
    {
        return $this->view('emails/register', ['code'=>$_SESSION['sign-in']['code']])->subject('Datarah Register');
    }
}

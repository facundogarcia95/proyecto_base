<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Lang;

class NotifyUserAdd extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $pass;
    public User $user;

    public function __construct(User $user, String $pass)
    {
        $this->pass = $pass;
        $this->user = $user;
        $this->subject(Lang::get('emails.notify_add_user'));
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.addUser',['user' => $this->user,'password'=>$this->pass]);
    }
}

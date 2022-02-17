<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Setting;

class InformRegistration extends Mailable
{
    use Queueable, SerializesModels;
    public $content;
    public $password;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($content, $password)
    {
        $this->content  = $content;
        $this->password  = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // $link = url( "/password_reset/?token=" . $this->token."&email=".$this->content->email );
        // $link = url( "/password_reset/?username=".$this->content->username );
        // $link = url( "/password_reset/?username=".$this->content->phone );
        $setting = Setting::find(1);
        $link = url("/login");
        return $this->markdown('emails.inform_registration')
        ->with('content', $this->content)
        ->with('password', $this->password)
        ->with('link', $link)
        ->with('setting', $setting);
    }
}

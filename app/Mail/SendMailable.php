<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMailable extends Mailable
{
    use Queueable, SerializesModels;
    public $text;
    public $subject;
    public $view_name;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subject,$sendTxt,$viewName)
    {
        $this->subject = $subject;
        $this->text = $sendTxt;
        $this->view_name = $viewName;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('goalachieve@afmc1.com')->subject($this->subject)->view("mail.".$this->view_name,["data"=>$this->text]);
    }
}

<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendWeeklyMail extends Mailable
{
    use Queueable, SerializesModels;

    public $email;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($tmp)
    {
        if (!isset($tmp['url'])) {
            $tmp['url'] = \env('APP_URL');
        }
        $this->email = $tmp;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.weekly-tmp')->subject($this->email['title'].' | 红砖图库');
    }
}
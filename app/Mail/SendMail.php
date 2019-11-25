<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Services\Apps;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;

    public $email;

    protected $intl;

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
        $this->intl = app(Apps::class)->intl()['email'];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.tmp')->subject($this->email['title'].' | '.$this->intl['siteName']);
    }
}

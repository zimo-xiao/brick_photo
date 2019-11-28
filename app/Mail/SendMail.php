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

    public $intl;

    protected $type;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($tmp, $type)
    {
        if (!isset($tmp['url'])) {
            $tmp['url'] = \env('APP_URL');
        }
        $this->intl = app(Apps::class)->intl()['email'];
        $this->email = $tmp;
        $this->type = $type;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.'.$this->type.'.tmp')->subject($this->email['title'].' | '.$this->intl['siteName']);
    }
}

<?php

namespace App\Jobs;

use Illuminate\Support\Facades\Mail;
use App\Mail\SendWeeklyMail;

class SendMailJob extends Job
{
    protected $tmp;

    protected $to;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($to, $tmp)
    {
        $this->to = $to;
        $this->tmp = $tmp;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->to)->send(new SendWeeklyMail($this->tmp));
    }
}
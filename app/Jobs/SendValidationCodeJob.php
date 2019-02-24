<?php

namespace App\Jobs;

use Illuminate\Support\Facades\Mail;
use App\Mail\SendValidationCode;

class SendValidationCodeJob extends Job
{
    protected $code;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($code)
    {
        $this->code = $code;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->code['email'])->send(new SendValidationCode($this->code));
    }
}
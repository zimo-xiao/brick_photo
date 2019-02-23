<?php

namespace App\Jobs;

use App\Http\Controllers\ValidationCodeController;

class StoreNewValidationJob extends Job
{
    protected $file;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($file)
    {
        $this->file = $file;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        app(ValidationCodeController::class)->store($this->file);
    }
}
<?php

namespace App\Jobs;

use App\Http\Controllers\ImageController;

class StoreNewImageJob extends Job
{
    protected $end;

    protected $total;

    protected $index;

    protected $name;

    protected $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($end, $total, $index, $name, $user)
    {
        $this->end = $end;
        $this->total = $total;
        $this->index = $index;
        $this->name = $name;
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        app(ImageController::class)->store($this->end, $this->total, $this->index, $this->name, $this->user);
    }
}
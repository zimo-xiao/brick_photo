<?php
namespace App\Jobs;

use App\Services\Files;
use App\Models\Image;

class StoreNewImageJob extends Job
{
    protected $end;

    protected $name;

    protected $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($name, $end, $user)
    {
        $this->end = $end;
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
        $file = new Files();
        $file->store($this->name, $this->end);

        app(Image::class)->insertTs([
            'author_id' => $this->user->id,
            'author_name' => $this->user->name,
            'file_name' => $this->name,
            'file_format' => $this->end,
            'tags' => json_encode([])
        ]);

        if (\env('USE_WATERMARK')) {
            dispatch(new StoreWatermarkJob($this->name, $this->end));
        }
    }
}

<?php

namespace App\Jobs;

use Intervention\Image\Facades\Image as ProcessImage;
use App\Services\Files;

class StoreWatermarkJob extends Job
{
    protected $fileName;

    protected $fileFormat;

    protected $file;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($fileName, $fileFormat)
    {
        $this->fileName = $fileName;
        $this->fileFormat = $fileFormat;
        $this->file = new Files();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $orgImage = ProcessImage::make((string) $this->file->get('raw/'.$this->fileName.'.'.$this->fileFormat));
        $width = round($orgImage->width()/(3.5));
        $watermarkImage = ProcessImage::make((string) $this->file->get('asset/watermark.png'));
        $height = round($width * $watermarkImage->height() / $watermarkImage->width());
        $watermarkImage->resize($width, $height)->opacity(50);
        $orgImage = $orgImage->insert($watermarkImage, 'center')->stream();
        $this->file->save(
            'watermark/'.$this->fileName.'.'.$this->fileFormat,
            $orgImage->__toString()
        );
    }
}

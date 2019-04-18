<?php

namespace App\Jobs;

use Intervention\Image\Facades\Image as ProcessImage;

class StoreWatermarkJob extends Job
{
    protected $fileName;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($fileName)
    {
        $this->fileName = $fileName;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $imageDir = \env('IMAGE_DIR');
        $rawImgDir = $imageDir.'/raw/'.$this->fileName;
        $watermarkDir = $imageDir.'/watermark/'.$this->fileName;
        $pubDir = \public_path();
        $watermarkCoverDir = $pubDir.'/image/logo.png';
        \ini_set('memory_limit', '5000M');
        $orgImage = ProcessImage::make($rawImgDir);
        $width = round($orgImage->width()/(3.5));
        $watermarkImage = ProcessImage::make($watermarkCoverDir);
        $height = round($width * $watermarkImage->height() / $watermarkImage->width());
        $watermarkImage->resize($width, $height)->opacity(50);
        $orgImage->insert($watermarkImage, 'center')->save($watermarkDir);
        chmod($watermarkDir, 0777);
    }
}
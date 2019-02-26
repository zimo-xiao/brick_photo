<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\Image;

class StoreImagesInBatchJob extends Job
{
    protected $usin;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($usin)
    {
        $this->usin = $usin;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $user = app(User::class)->where(['usin' => $this->usin])->get();
        if (count($user) > 0) {
            $user = $user[0];
            $storageDir = \storage_path();
            $uploadDir = \env('UPLOAD_DIR');
            $srcDir = $storageDir.'/'.$uploadDir.'/';

            $nodeDir = $storageDir;

            $pubDir = \public_path();
            $imageDir = \env('IMAGE_DIR');
            $toRawDir = $pubDir.'/'.$imageDir.'/raw/';
            $toCacheDir = $pubDir.'/'.$imageDir.'/cache/';
        
            $files = scandir($srcDir);
            foreach ($files as $file) {
                try {
                    $end = strtolower($file) ?? null;

                    if (strpos($end, '.jpg') !== false || strpos($end, '.jpeg') !== false) {
                        $end = 'jpg';
                    } elseif (strpos($end, '.png') !== false) {
                        $end = 'png';
                    }

                    if ($end === 'jpg' || $end === 'png') {
                        $fhash = hash_file("md5", $srcDir.'/'.$file, false);
                        $fhash = $fhash.date('YmdHis', time());
                        exec('node '.$nodeDir.'/compress.js "'.$toRawDir.'" "'.$toCacheDir.'" "'.$srcDir.$file.'" '.$fhash.' '.$end);
                        //
                        app(Image::class)->insertTs([
                            'author_id' => $user['id'],
                            'author_name' => $user['name'],
                            'file_name' => $fhash,
                            'file_format' => $end
                        ]);
                    }
                } catch (\Exception $e) {
                }
            }
        }
    }
}
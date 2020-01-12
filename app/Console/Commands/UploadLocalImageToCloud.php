<?php
/**
 *
 * PHP version >= 7.0
 *
 * @category Console_Command
 * @package  App\Console\Commands
 */

namespace App\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use App\Services\Files;

/**
 * Class UpdateStudentClassRank
 *
 * @category Console_Command
 * @package  App\Console\Commands
 */
class UploadLocalImageToCloud extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = "go:image";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Upload image to cloud";

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $path = '/home/brick_photo/public/storage/images/raw/';
        $images = scandir($path);
        $this->upload($path, 'raw', $images);
        $path = '/home/brick_photo/public/storage/images/cache/';
        $images = scandir($path);
        $this->upload($path, 'cache', $images);
        $path = '/home/brick_photo/public/storage/images/watermark/';
        $images = scandir($path);
        $this->upload($path, 'watermark', $images);
    }

    private function upload($path, $type, $images)
    {
        $files = new Files();
        foreach ($images as $image) {
            $lowerName = strtolower($image);
            if (strpos($lowerName, '.png') || strpos($lowerName, '.jpg') || strpos($lowerName, '.jpeg')) {
                $this->info('uploading '.$image.' to '.$type);
                $files->path($type.'/'.$image, (string) File::get($path.$image));
            }
        }
    }
}
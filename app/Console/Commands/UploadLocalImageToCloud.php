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
use App\Models\Image;

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
        $images = app(Image::class)->all();
        foreach($images as $image) {
            try {
                $this->upload($image['path'], $image['file_name'].''.$image['file_format']);
            } catch(\Exception $e) {
                $this->info('error when processing '.$image['file_name']);
            }
        }
    }

    private function upload($path, $image)
    {
        $files = new Files();
        $this->info('uploading '.$image.' to raw');
        $files->path('raw/'.$image, (string) File::get($path.'raw/'.$image));
        $this->info('uploading '.$image.' to cache');
        $files->path('raw/'.$image, (string) File::get($path.'cache/'.$image));
        $this->info('uploading '.$image.' to watermark');
        $files->path('raw/'.$image, (string) File::get($path.'watermark/'.$image));
    }
}

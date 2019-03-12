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
use App\Models\Image;

/**
 * Class UpdateStudentClassRank
 *
 * @category Console_Command
 * @package  App\Console\Commands
 */
class DeleteImageAfterAWeek extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = "delete:images";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Delete Images Per Week";


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $images = app(Image::class)->onlyTrashed()->get();
        foreach ($images as $image) {
            $rawDir = $image['path'].'/raw/'.$image['file_name'].'.'.$image['file_format'];
            $watermarkDir = $image['path'].'/watermark/'.$image['file_name'].'.'.$image['file_format'];
            $cacheDir = $image['path'].'/cache/'.$image['file_name'].'.'.$image['file_format'];
            try {
                unlink($rawDir);
            } catch (\Exception $e) {
                //
            }

            try {
                unlink($watermarkDir);
            } catch (\Exception $e) {
                //
            }

            try {
                unlink($cacheDir);
            } catch (\Exception $e) {
                //
            }
        }
        app(Image::class)->onlyTrashed()->forceDelete();
    }
}
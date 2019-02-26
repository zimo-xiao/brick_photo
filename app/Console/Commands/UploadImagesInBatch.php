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
use App\Jobs\StoreImagesInBatchJob;

/**
 * Class UpdateStudentClassRank
 *
 * @category Console_Command
 * @package  App\Console\Commands
 */
class UploadImagesInBatch extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = "upload:images {usin}";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Upload Images In Batches";


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        dispatch(new StoreImagesInBatchJob($this->argument('usin')));
    }
}
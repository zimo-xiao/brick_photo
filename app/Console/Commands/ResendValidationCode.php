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
use App\Models\ValidationCode;
use App\Jobs\SendMailJob;
use Carbon\Carbon;

/**
 * Class UpdateStudentClassRank
 *
 * @category Console_Command
 * @package  App\Console\Commands
 */
class ResendValidationCode extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = "resend:code";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Resend Validation Code";


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $codes = app(ValidationCode::class)->where('created_at', '<', Carbon::today()->subDays(2));
        echo json_encode($codes);
    }
}
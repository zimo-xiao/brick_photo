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
use App\Jobs\SendMailJob;
use App\Models\Delete;
use App\Models\User;
use Carbon\Carbon;
use App\Services\Apps;

/**
 * Class UpdateStudentClassRank
 *
 * @category Console_Command
 * @package  App\Console\Commands
 */
class SendDeleteEmails extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = "send:delete";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Send email per day";


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $todayDeleted = app(Delete::class)->whereDate('created_at', Carbon::today())->get();

        $indexedTodayDeleted = [];

        foreach ($todayDeleted as $t) {
            if (!isset($indexedTodayDeleted[$t['author_id']])) {
                $author = app(User::class)->find($t['author_id']);
                $indexedTodayDeleted[$author->id] = [
                    'name' => $author->name,
                    'data' => [],
                    'email' => $author->email
                ];
            }
            $indexedTodayDeleted[$t['author_id']]['data'][] = $t;
        }
        
        foreach ($indexedTodayDeleted as $k => $i) {
            dispatch(new SendMailJob($i['email'], $this->emailText($i['name'], $i['data'])));
        }
    }

    private function emailText($name, $data)
    {
        $app = app(Apps::class)->intl()['sendDeleteEmails'];
        $content = str_replace('[count]', count($data), $app['contentTitle']);

        foreach ($data as $d) {
            $tmp = str_replace('[id]', $d['image_id'], $app['contentItem']);
            $tmp = str_replace('[reason]', $d['reason'], $tmp);
            $content .= $tmp;
        }
        
        return [
            'name' => $name,
            'description' => $content,
            'title' => $app['title']
        ];
    }
}
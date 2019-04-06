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
        $content = '有'.count($data).'张图片被管理员删除，如有疑问请联系：微信号lrh20021108';

        foreach ($data as $d) {
            $content .= "\n\n编号为**".$d['image_id'].'的图片被管理员删除；原因：**'.$d['reason'].'**';
        }
        
        return [
            'name' => $name,
            'description' => $content,
            'title' => '图片删除通知'
        ];
    }
}
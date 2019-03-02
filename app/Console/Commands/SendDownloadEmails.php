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
use App\Models\Download;
use App\Models\Image;
use App\Models\User;
use Carbon\Carbon;

/**
 * Class UpdateStudentClassRank
 *
 * @category Console_Command
 * @package  App\Console\Commands
 */
class SendDownloadEmails extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = "send:download";

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
        $todayDownload = app(Download::class)->whereDate('created_at', Carbon::today())->get();

        $indexedTodayDownload = [];

        foreach ($todayDownload as $t) {
            $image = app(Image::class)->find($t['image_id']);
            if (!isset($indexedTodayDownload[$image->author_id])) {
                $author = app(User::class)->find($image->author_id);
                $indexedTodayDownload[$author->id] = [
                    'name' => $author->name,
                    'data' => [],
                    'email' => $author->email
                ];
            }
            $indexedTodayDownload[$image->author_id]['data'][] = $t;
        }
        
        foreach ($indexedTodayDownload as $k => $i) {
            dispatch(new SendMailJob($i['email'], $this->emailText($i['name'], $i['data'])));
        }
    }

    private function emailText($name, $data)
    {
        $content = '今天一共有'.count($data).'次图片下载';

        foreach ($data as $d) {
            $content .= "\n\n".$d['downloader_name'].'下载了你编号为**'.$d['image_id'].'**的图片，使用原因为：**'.$d['usage'].'**';
        }
        
        return [
            'name' => $name,
            'description' => $content,
            'title' => '下载图片提醒'
        ];
    }
}
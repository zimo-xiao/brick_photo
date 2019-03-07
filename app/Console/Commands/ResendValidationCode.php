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
        $codes = app(ValidationCode::class)->where('created_at', '<', Carbon::today()->subDays(7))->get();
        foreach ($codes as $code) {
            dispatch(new SendMailJob($code['email'], $this->emailText($code)));
        }
    }

    private function emailText($input)
    {
        return [
            'name' => $input['name'],
            'description' => "红砖邀请你加入\n\n我们向你发送红砖图库的邀请码\n\n\n你的激活码是：**".$input['code']."**\n\n\n你可以点击链接右侧按照[我们的用户手册](https://shimo.im/docs/1Z7Xhh9IUhg51ym7/)中的指导来使用红砖。\n\n\n如有疑问，请联系：微信号lrh20021108",
            'title' => '你错过了什么嘛？'
        ];
    }
}
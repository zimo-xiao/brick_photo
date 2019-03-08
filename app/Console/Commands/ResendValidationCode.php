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
            'description' => "您的激活码是：**".$input['code']."**\n\n我们是红砖社团，很高兴向您发送这封邮件。我们将在以下介绍「红砖图库」，并向您发放注册激活码。如果您已熟知「红砖图库」，可以依照邮件末尾处的指示完成注册。\n\n\n### 一、「红砖图库」是什么？\n\n「红砖图库」(以下正文简称\"红砖\")是当前北京大学附属中学最大的图片库，面向全校同学和附中校友免费开放，并已有数十位摄影师入驻。我们的目的是以图片的形式收集北大附中的校园记忆，并在保证作者权益的情况下让这些图片得到合理的使用。\n\n\n### 二、「红砖图库」能带来什么？\n\n红砖保存上千张优质的附中照片。学校可以将这些照片用于校友活动；校内的社团和书院可以使用这些照片作为宣传用途；附中的普通同学也可以将这些图片设置成手机和电脑的壁纸。红砖使校内的学生团体宣传找图变得更加容易。\n\n\n### 三、「红砖图库」的注册流程\n\n「红砖图库」采用个人激活码注册，您的激活码是：**".$input['code']."**\n\n请访问[「红砖图库」](https://hong.zuggr.com)并于页面右上角完成注册。\n\n你可以点击右侧链接按照[我们的用户手册](https://shimo.im/docs/1Z7Xhh9IUhg51ym7/)中的指导来使用「红砖图库」。\n\n如有任何疑问，请联系微信：lrh20021108",
            'title' => '再次邀请您加入，不要错过哦'
        ];
    }
}
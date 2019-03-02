<?php

namespace App\Http\Controllers;

use App\Imports\ValidationCodeImport;
use App\Models\ValidationCode;
use Illuminate\Http\Request;
use App\Models\User;
use App\Jobs\SendMailJob;
use Maatwebsite\Excel\Facades\Excel;

class ValidationCodeController extends Controller
{
    public function upload(Request $request)
    {
        $this->validate($request, [
            'file' => 'required',
        ]);

        if ($request->user()->permission != User::PERMISSION_ADMIN) {
            return response()->json([
                'error_msg' => '没有权限'
            ], 401);
        }

        try {
            Excel::load($request->file('file'), function ($reader) {
                foreach ($reader->toArray() as $row) {
                    try {
                        if (
                            filter_var($row['email'], FILTER_VALIDATE_EMAIL) &&
                            $row['name'] != null && $row['usin'] != null && $row['email'] != null
                        ) {
                            $input = [
                                'code' => app(ValidationCode::class)->generateCode(),
                                'name' => $row['name'],
                                'usin' => $row['usin'],
                                'email' => $row['email']
                            ];
                            
                            app(ValidationCode::class)->insertTs($input);
                            dispatch(new SendMailJob($input['email'], $this->emailText($input)));
                        }
                    } catch (\Exception $e) {
                        // 如果输入不进去则跳过
                    }
                }
            });
        } catch (\Exception $e) {
            return $e;
            return response()->json([
                'error_msg' => 'Excel格式错误',
            ], 401);
        }

        return response()->json([
            'code' => 0
        ]);
    }

    private function emailText($input)
    {
        return [
            'name' => $input['name'],
            'description' => "我们现在向你发送红砖图库的邀请码\n\n\n你的激活码是：**".$input['code']."**\n\n\n希望你可以点击链接右侧按照[我们的用户手册](https://shimo.im/docs/1Z7Xhh9IUhg51ym7/)中的指导来使用红砖。",
            'title' => '发送激活码'
        ];
    }

    public function export(Request $request)
    {
        $user = $this->user($request);
        if ($user->permission === User::PERMISSION_ADMIN) {
            $codes = app(ValidationCode::class)->all();
            return Excel::create('未激活的激活码', function ($excel) use ($codes) {
                $excel->sheet('Sheet 1', function ($sheet) use ($codes) {
                    $sheet->fromArray($codes);
                });
            })->export('xls');
        } else {
            return '你没有权限';
        }
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\ValidationCodeImport;
use App\Models\ValidationCode;
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
                    if (filter_var($row['email'], FILTER_VALIDATE_EMAIL)) {
                        $row['code'] = app(ValidationCode::class)->generateCode();
                        app(ValidationCode::class)->insert($row);
                        dispatch(new SendMailJob($row['email'], $this->emailText($row)));
                    }
                }
            });
        } catch (\Exception $e) {
            return response()->json([
                'error_msg' => 'Excel格式错误',
            ], 401);
        }

        return response()->json([
            'code' => 0
        ]);
    }

    private function emailText($row)
    {
        return [
            'name' => $row['name'],
            'description' => '您的激活码是：**'.$row['code'].'**',
            'title' => '发送激活码'
        ];
    }
}
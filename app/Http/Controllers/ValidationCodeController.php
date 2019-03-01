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
                    try {
                        if (filter_var($row['email'], FILTER_VALIDATE_EMAIL)) {
                            $row['code'] = app(ValidationCode::class)->generateCode();
                            app(ValidationCode::class)->insert($row);
                            dispatch(new SendMailJob($row['email'], $this->emailText($row)));
                        }
                    } catch (\Exception $e) {
                        // 如果输入不进去则跳过
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

    /**
     * Get user data from token
     *
     * @return [response] view
     */
    private function user($request)
    {
        $token = $request->session()->get('token');
        if ($request->session()->get('token') != null) {
            if (\Cache::store('redis')->has($token)) {
                return json_decode(\Cache::store('redis')->get($token));
            } else {
                $data = Curl::to($request->root().'/auth')
                    ->withHeader('Authorization: Bearer '.$token)
                    ->asJson()
                    ->get();
                \Cache::store('redis')->put($token, json_encode($data), 60);
                return $data;
            }
        } else {
            return json_decode(json_encode([
                'name' => null,
                'permission' => null,
                'id' => null,
                'usin' => null
            ]));
        }
    }
}
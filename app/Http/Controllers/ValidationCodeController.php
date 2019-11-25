<?php

namespace App\Http\Controllers;

use App\Imports\ValidationCodeImport;
use App\Models\ValidationCode;
use Illuminate\Http\Request;
use App\Models\User;
use App\Jobs\SendMailJob;
use Maatwebsite\Excel\Facades\Excel;
use App\Services\Apps;

class ValidationCodeController extends Controller
{
    protected $intl;

    public function __construct()
    {
        $this->intl = app(Apps::class)->intl()['validationCodeController'];
    }

    public function upload(Request $request)
    {
        $this->validate($request, [
            'file' => 'required',
        ]);

        if ($request->user()->permission != User::PERMISSION_ADMIN) {
            return response()->json([
                'error_msg' => $this->intl['permissionDenied']
            ], 401);
        }

        try {
            $errors = [];
            Excel::load($request->file('file'), function ($reader) use (&$errors) {
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
                        $errors[] = $e->getMessage();
                    }
                }
            });
        } catch (\Exception $e) {
            return $e;
            return response()->json([
                'error_msg' => $this->intl['excelFormatError'],
            ], 401);
        }

        return response()->json([
            'msg' => count($errors) == 0 ? $this->intl['uploadSuccess'] : implode("\n", $errors)
        ]);
    }

    private function emailText($input)
    {
        return [
            'name' => $input['name'],
            'description' => str_replace('[code]', $input['code'], $this->intl['validationCodeEmail']['description']),
            'title' => $this->intl['validationCodeEmail']['title'],
            'url' => \env('APP_URL').'/?show=register'
        ];
    }

    public function export(Request $request)
    {
        $user = $this->user($request);
        if ($user->permission === User::PERMISSION_ADMIN) {
            $codes = app(ValidationCode::class)->all();
            return Excel::create($this->intl['exportExcelTitle'], function ($excel) use ($codes) {
                $excel->sheet('Sheet 1', function ($sheet) use ($codes) {
                    foreach ($codes as $k => $u) {
                        $codes[$k]['email'] = $this->blurText($u['email'], 4);
                    }
                    $sheet->fromArray($codes);
                });
            })->export('xls');
        } else {
            return $this->intl['permissionDenied'];
        }
    }
}
<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\ValidationCode;
use Illuminate\Http\Request;
use App\Models\User;
use App\Jobs\SendMailJob;
use Maatwebsite\Excel\Facades\Excel;
use App\Excels\ExportValidationCodes;
use App\Services\Apps;
use App\Excels\ImportValidationCode;

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
            Excel::import(new ImportValidationCode, $request->file('file'));
        } catch (\Exception $e) {
            return response()->json([
                'error_msg' => $this->intl['excelFormatError'],
            ], 401);
        }

        return response()->json([
            'msg' => $this->intl['uploadSuccess']
        ]);
    }

    public function post(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
        ]);
        $email = $request->input('email');
        $mustEndWith = $this->intl['mustEndWith'];
        if (strstr($email, $mustEndWith) != false) {
            $pastCode = app(ValidationCode::class)
                ->where(['email' => $email])
                ->where('created_at', '>', Carbon::now()->subMinutes(1))
                ->first();

            if ($pastCode) {
                return response()->json([
                    'error_msg' => str_replace('[email]', $mustEndWith, $this->intl['frequentRequestError'])
                ], 401);
            }

            $user = [
                'code' => app(ValidationCode::class)->generateCode(),
                'name' => 'isMustEndWith',
                'usin' => app(ValidationCode::class)->generateCode(),
                'email' => $email
            ];
            
            app(ValidationCode::class)->where(['email' => $email])->forceDelete();
            app(ValidationCode::class)->insertTs($user);
            dispatch(new SendMailJob($user['email'], $this->emailText($user)));
        }

        return response()->json([
            'error_msg' => str_replace('[email]', $mustEndWith, $this->intl['mustEndWithError'])
        ], 401);
    }

    public function export(Request $request)
    {
        $user = $this->user($request);
        if ($user->permission === User::PERMISSION_ADMIN) {
            return Excel::download(new ExportValidationCodes, $this->intl['exportExcelTitle'].'.xlsx');
        }

        return $this->intl['permissionDenied'];
    }

    private function emailText($input)
    {
        return [
            'name' => ' ',
            'description' => str_replace('[code]', $input['code'], $this->intl['validationCodeEmail']['description']),
            'title' => $this->intl['validationCodeEmail']['title'],
            'url' => \env('APP_URL').'/?show=register'
        ];
    }
}
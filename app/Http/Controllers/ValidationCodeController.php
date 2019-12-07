<?php

namespace App\Http\Controllers;

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
            return Excel::download(new ExportValidationCodes, $this->intl['exportExcelTitle'].'.xlsx');
        } else {
            return $this->intl['permissionDenied'];
        }
    }
}

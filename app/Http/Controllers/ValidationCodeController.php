<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\ValidationCodeImport;
use App\Models\ValidationCode;
use App\Models\User;
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

        dispatch(new StoreNewValidationCodeJob($request->file('file')));
    }

    /**
     * Store code in queue from excel
     *
     * @return [response] view
     */
    public function store($file)
    {
        Excel::load($file, function ($reader) {
            foreach ($reader->toArray() as $row) {
                app(ValidationCode::class)->insert($row);
            }
        });
    }
}
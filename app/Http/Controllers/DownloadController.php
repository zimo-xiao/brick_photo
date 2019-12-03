<?php

namespace App\Http\Controllers;

use App\Models\Download;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Image;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;
use App\Services\Apps;
use App\Services\Files;

class DownloadController extends Controller
{
    protected $intl;

    protected $file;

    public function __construct()
    {
        $this->intl = app(Apps::class)->intl()['downloadController'];
        $this->file = new Files(\env('APP_FILE_SYSTEM'));
    }

    public function view(Request $request, $id)
    {
        $this->validate($request, [
            'usage' => 'required'
        ]);

        $usage = $request->input('usage');
        $image = app(Image::class)->find($id);
        if (!$image) {
            return response()->json([
                'error_msg' => $this->intl['imgNotExits']
            ], 401);
        }

        app(Download::class)->insertTs([
            'downloader_id' => $request->user()->id,
            'downloader_name' => $request->user()->name,
            'image_id' => $id,
            'usage' => $usage
        ]);

        $code = $this->generateNumericKey();
        while (\Cache::store('redis')->has($code)) {
            $code = $this->generateNumericKey();
        }
        \Cache::store('redis')->put($code, $id, 5);
        
        return response()->json([
            'code' => $code
        ]);
    }

    public function action(Request $request, $code)
    {
        if (\Cache::store('redis')->has($code)) {
            $imgId = \Cache::store('redis')->get($code);
            \Cache::store('redis')->delete($code);

            $user = $this->user($request);
            $image = app(Image::class)->find($imgId);
            if ($image) {
                $name = $image->file_name.'.'.$image->file_format;
                if ($user->permission === User::PERMISSION_ADMIN) {
                    return $this->responseImageFromPath($image->path, 'raw', $name);
                } else {
                    return $this->responseImageFromPath($image->path, 'watermark', $name, $this->intl['imgProcessNotComplete']);
                }
            } else {
                return $this->intl['imgNotExits'];
            }
        } else {
            return $this->intl['expiredDownloadSession'];
        }
    }

    public function export(Request $request)
    {
        $user = $this->user($request);
        if ($user->permission === User::PERMISSION_ADMIN) {
            $users = app(Download::class)->all();
            return Excel::create($this->intl['downloadActivity'], function ($excel) use ($users) {
                $excel->sheet('Sheet 1', function ($sheet) use ($users) {
                    $sheet->fromArray($users);
                });
            })->export('xls');
        } else {
            return $this->intl['permissionDenied'];
        }
    }
}

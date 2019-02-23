<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Download;
use App\Models\Image;

class DownloadController extends Controller
{
    public function view(Request $request, $id)
    {
        $image = app(Image::class)->find($id);
        if (!$image) {
            return response()->json([
                'error_msg' => '图片不存在'
            ], 401);
        }

        app(Download::class)->insert([
            'downloader_id' => $request->user()->id,
            'image_id' => $id
        ]);

        $pubDir = \public_path();
        $imageDir = \env('IMAGE_DIR');
        $rawImg = $pubDir.'/'.$imageDir.'/raw/'.$image->file_name.'.'.$image->file_format;
        return response()->download($rawImg);
    }
}
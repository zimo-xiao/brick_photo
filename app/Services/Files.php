<?php

namespace App\Services;

use League\Flysystem\Filesystem;
use Illuminate\Support\Facades\Storage;

class Files
{
    public function upload($name, $no, $content)
    {
        if ($no === 0) {
            Storage::put('tmp/'.$name, $content);
        } else {
            Storage::append('tmp/'.$name, $content);
        }
        Storage::setVisibility('tmp/'.$name, 'private');
    }

    public function save($path, $content, $isPublic = false){
        Storage::put($path, $content);

        if ($isPublic) {
            Storage::setVisibility($path, 'public');
        } else {
            Storage::setVisibility($path, 'private');
        }
    }

    public function store($name, $end)
    {
        $content = $this->get('tmp/'.$name);

        $content = explode('#**#', $content);

        $cache = \base64_decode(substr($content[0], \strpos($content[0], ',') + 1));

        $raw = \base64_decode(substr($content[1], \strpos($content[1], ',') + 1));

        Storage::put('raw/'.$name.'.'.$end, $raw);
        Storage::setVisibility('raw/'.$name.'.'.$end, 'private');

        Storage::put('cache/'.$name.'.jpg', $cache);
        Storage::setVisibility('raw/'.$name.'.'.$end, 'public');

        Storage::setVisibility('tmp/'.$name, 'private');
        Storage::delete('tmp/'.$name);
    }

    public function exists($path){
        return Storage::exists($path);
    }

    public function get($path)
    {
        return Storage::get($path);
    }
}
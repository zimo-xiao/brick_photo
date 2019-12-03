<?php

namespace App\Services;

use League\Flysystem\Filesystem;
use Illuminate\Support\Facades\Storage;

class Files
{
    protected $type;

    public function __construct($type)
    {
        $this->type = $type;
    }

    public function upload($name, $no, $content)
    {
        switch ($this->type) {
            case 'do':
                if ($no === 0) {
                    Storage::put('tmp/'.$name, $content);
                } else {
                    Storage::append('tmp/'.$name, $content);
                }
                Storage::setVisibility('tmp/'.$name, 'private');
                break;
        }
    }

    public function store($name, $end)
    {
        $content = $this->do('tmp/'.$name);

        $content = explode('#**#', $content);

        $cache = \base64_decode(substr($content[0], \strpos($content[0], ',') + 1));

        $raw = \base64_decode(substr($content[1], \strpos($content[1], ',') + 1));

        switch ($this->type) {
            case 'do':
                Storage::put('raw/'.$name.'.'.$end, $raw);
                Storage::put('cache/'.$name.'.jpg', $cache);
                Storage::setVisibility('tmp/'.$name, 'private');
                Storage::delete('tmp/'.$name);
                break;
        }
    }

    public function getCloudUrl()
    {
        switch ($this->type) {
            case 'do':
                return env('DO_SPACES_ENDPOINT').'/'.env('DO_SPACES_BUCKET');
        }
    }

    public function get($path)
    {
        switch ($this->type) {
            case 'do':
                return Storage::get($this->removeUrl($path));
        }
    }

    private function removeUrl($path)
    {
        $out = str_replace('https://', '', $path);
        $out = explode('/', $out);
        array_shift($out);
        return implode('/', $out);
    }
}
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

    public function upload($path, $name, $no, $content)
    {
        $content = base64_decode($content);
        switch ($this->type) {
            case 'do':
                if ($no === 0) {
                    Storage::put($path.'/'.$name, $content);
                } else {
                    Storage::append($path.'/'.$name, $content);
                }
                Storage::setVisibility($path.'/'.$name, 'private');
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
<?php

namespace App;

class Helpers
{
    public static function toObject($input)
    {
        return json_decode(json_encode($input));
    }

    public static function toArray($input)
    {
        return json_decode(json_encode($input), true);
    }

    public static function parseBoolean($input)
    {
        return filter_var($input, FILTER_VALIDATE_BOOLEAN);
    }

    public static function parseNull($input)
    {
        if ($input === 'null') {
            return null;
        } else {
            return $input;
        }
    }

    public static function indexArrayByValue($array, $index)
    {
        $out = [];
        foreach ($array as $a) {
            $out[$a[$index]] = $a;
        }
        return $out;
    }

    public static function getElementsByKey($array, $index)
    {
        $out = [];
        foreach ($array as $a) {
            $out[] = $a[$index];
        }
        return $out;
    }
}
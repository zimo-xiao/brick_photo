<?php

namespace App\Excels;

use App\Models\ValidationCode;
use App\Helpers;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportValidationCodes implements FromCollection
{
    public function collection()
    {
        $codes = ValidationCode::all();

        foreach ($codes as &$code) {
            $code->email = Helpers::blurText($code->email, 4);
        }

        return $codes;
    }
}
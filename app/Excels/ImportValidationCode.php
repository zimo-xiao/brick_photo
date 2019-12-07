<?php

namespace App\Excels;

use App\Models\ValidationCode;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;

class ImportValidationCode implements ToModel
{
    /**
     * @param array $row
     *
     * @return User|null
     */
    public function model(array $row)
    {
        return new ValidationCode([
            'code' => app(ValidationCode::class)->generateCode(),
            'name'     => $row[0],
            'usin'    => $row[1],
            'email' => $row[2],
        ]);
    }
}

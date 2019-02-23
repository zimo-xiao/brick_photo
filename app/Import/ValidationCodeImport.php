<?php

namespace App\Imports;

use App\Models\ValidationCode;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;

class ValidationCodeImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return User|null
     */
    public function model(array $row)
    {
        return new User([
           'name'     => $row[0],
           'email'    => $row[1],
           'password' => Hash::make($row[2]),
        ]);
    }
}
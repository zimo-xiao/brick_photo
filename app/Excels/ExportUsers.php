<?php

namespace App\Excels;

use App\Models\User;
use App\Helpers;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportUsers implements FromCollection
{
    public function collection()
    {
        $users = User::all();

        foreach ($users as &$user) {
            $user->email = Helpers::blurText($user->email, 4);
        }

        return $users;
    }
}
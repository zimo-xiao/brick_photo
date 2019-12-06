<?php

namespace App\Excels;

use App\Models\Download;
use App\Helpers;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportDownloads implements FromCollection
{
    public function collection()
    {
        return Download::all();
    }
}
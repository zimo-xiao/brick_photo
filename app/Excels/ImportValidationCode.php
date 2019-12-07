<?php

namespace App\Excels;

use App\Models\ValidationCode;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use App\Jobs\SendMailJob;
use App\Services\Apps;

class ImportValidationCode implements ToModel
{
    protected $intl;

    public function __construct()
    {
        $this->intl = app(Apps::class)->intl()['validationCodeController'];
    }

    /**
     * @param array $row
     *
     * @return User|null
     */
    public function model(array $row)
    {
        $user = [
            'code' => app(ValidationCode::class)->generateCode(),
            'name' => $row[0],
            'usin' => $row[1],
            'email' => $row[2],
        ];

        $model = new ValidationCode($user);

        dispatch(new SendMailJob($user['email'], $this->emailText($input)));

        return $model;
    }
    private function emailText($input)
    {
        return [
            'name' => $input['name'],
            'description' => str_replace('[code]', $input['code'], $this->intl['validationCodeEmail']['description']),
            'title' => $this->intl['validationCodeEmail']['title'],
            'url' => \env('APP_URL').'/?show=register'
        ];
    }
}
<?php

namespace App\Models;

use Keygen\Keygen;

class ValidationCode extends BaseModel
{
    protected $primaryKey = 'code';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'code', 'usin', 'email'
    ];

    public function generateCode()
    {
        $code = $this->generateNumericKey();

        // Ensure Code does not exist
        // Generate new one if ID already exists
        while ($this->where(['code'=>$code])->count() > 0) {
            $code = $this->generateNumericKey();
        }

        return $code;
    }

    private function generateNumericKey()
    {
        return Keygen::numeric(6)->prefix(mt_rand(1, 9))->generate(true);
    }
}
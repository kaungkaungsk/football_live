<?php

namespace App\Traits;

use Illuminate\Support\Facades\Crypt;

trait CipherTrait
{
    public function encryptData($data)
    {
        return $data;
        return Crypt::encrypt($data);
    }
}

<?php

namespace App\Traits;

use Google\Rpc\Context\AttributeContext\Response;
use Illuminate\Support\Facades\Crypt;

trait CipherTrait
{
    public function encryptData($data)
    {
        // return $data;
        return  response(['challenge' => Crypt::encrypt($data)]);
    }
}

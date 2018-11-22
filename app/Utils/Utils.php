<?php

namespace App\Utils;

use Illuminate\Hashing\BcryptHasher;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;


class Utils
{

    static public function errorResponse($arrayOfError)
    {
        return response(array(
            'error' => true,
            'message' => $arrayOfError
        ), 400);
    }

}
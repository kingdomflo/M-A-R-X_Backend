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

    static public function errorResponseNotFound($item)
    {
        return response(array(
            'error' => true,
            'message' => ['The ' . $item . ' you\'re searching didn\'t exist']
        ), 404);
    }

    static public function errorResponseNotBelongToYou($item)
    {
        return response(array(
            'error' => true,
            'message' => ['The ' . $item . ' didn\'t belong to you']
        ), 409);
    }

}
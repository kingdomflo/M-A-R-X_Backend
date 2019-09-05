<?php

namespace App\Utils;

use Illuminate\Hashing\BcryptHasher;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Models\MarxRelationshipTypeTranslation;

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

    static public function camelCaseKeys(Array $array)
    {
        $formatted = [];
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $formatted[Str::camel($key)] = Utils::camelCaseKeys($value);
            } else {
                $formatted[Str::camel($key)] = $value;    
            }
        }
        return $formatted;        
    }
    
    static public function translateRelationshipType($lang, $relationshipType)
    {
        if(!in_array($lang, Utils::listOfAcceptedlanguage())) {
            $lang = 'en';
        }

        $translation = MarxRelationshipTypeTranslation::where('lang', '=', $lang)
            ->where('code', '=', $relationshipType['code'])->first();

        if ($translation != null) {
            $relationshipType['name'] = $translation['name'];
        }
        
        return $relationshipType;
    }

    static public function listOfAcceptedLanguage()
    {
        return array('fr', 'nl', 'de', 'no');
    }

}
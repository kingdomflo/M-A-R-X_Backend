<?php

namespace App\Http\Controllers;

use Illuminate\Hashing\BcryptHasher;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

use App\Models\MarxRelationship;
use App\Models\MarxRelationshipType;
use App\Models\MarxUserRelationshipType;
use App\Models\MarxUser;
use App\Models\MarxCurrencies;

use App\Utils\Utils;

class CurrenciesController extends Controller
{

  public function __construct()
  {
    //To have security
    $this->middleware('auth', ['only' => [
      'getAll'
    ]]);
  }

  public function getAll(Request $request)
  {
    $list = MarxCurrencies::all();
    return $list;
  }

}
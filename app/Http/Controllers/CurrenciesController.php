<?php

namespace App\Http\Controllers;

use Illuminate\Hashing\BcryptHasher;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

use App\MarxRelationship;
use App\MarxRelationshipType;
use App\MarxUserRelationshipType;
use App\MarxUser;
use App\MarxCurrencies;

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
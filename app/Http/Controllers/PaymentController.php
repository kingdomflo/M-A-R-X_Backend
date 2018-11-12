<?php

namespace App\Http\Controllers;

use Illuminate\Hashing\BcryptHasher;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Parser;

use App\MarxRelationship;
use App\MarxUser;
use App\MarxRelationshipType;
use App\MarxUserRelationshipType;
use App\MarxCurrencies;
use App\MarxUserCurrencies;
use App\MarxPayment;

class PaymentController extends Controller
{

  public function __construct()
  {
    //To have security
    $this->middleware('auth', ['only' => [
      'getAllByUser', 'getOneByUser'
    ]]);
  }

  public function getAllByUser(Request $request)
  {
    $whereArray = array(['user_id', '=', $request->input('token_user_id')]);
    if ($request->input('type') != null) {
      $whereArray[] = (['type', '=', $request->input('type')]);
    }

    $list = MarxPayment::where($whereArray)
      ->with('relationship')
      ->with('user_currency')
      ->get();

    return $list;
  }

  public function getOneByUser(Request $request, $id)
  {
    $payment = MarxPayment::where('id', '=', $id)
      ->where('user_id', '=', $request->input('token_user_id'))
      ->with('relationship')
      ->with('user_currency')
      ->first();
    return response()->json($payment);
  }

}
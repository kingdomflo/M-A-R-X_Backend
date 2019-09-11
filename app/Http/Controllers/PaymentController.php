<?php

namespace App\Http\Controllers;

use Illuminate\Hashing\BcryptHasher;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Parser;

use App\Models\MarxRelationship;
use App\Models\MarxUser;
use App\Models\MarxRelationshipType;
use App\Models\MarxUserRelationshipType;
use App\Models\MarxCurrencies;
use App\Models\MarxUserCurrencies;
use App\Models\MarxPayment;
use App\Models\MarxCurrency;

use App\Utils\Utils;

class PaymentController extends Controller
{

  public function __construct()
  {
    //To have security
    $this->middleware('auth', ['only' => [
      'getAllByUser',
      'getOneByUser',
      'delete',
      'create',
      'update',
      'refunded',

      'getAllPayment',
      'getOnePayment',
      'createPayment',
      'refundedPayment',
      'getSuggestedCurrencies'
    ]]);
  }

  public function getAllPayment(Request $request)
  {
    $whereArray = array(['user_id', '=', $request->input('token_user_id')]);
    if ($request->input('type') != null) {
      $whereArray[] = (['type', '=', $request->input('type')]);
    }
    if ($request->input('relationship_id') != null) {
      $whereArray[] = (['relationship_id', '=', $request->input('relationship_id')]);
    }
    if ($request->input('refunded') != null) {
      $refundBool;
      if ($request->input('refunded') == 'false') {
        $refundBool = 0;
      } else {
        $refundBool = 1;
      }
      $whereArray[] = (['refunded', '=', $refundBool]);
    }

    $list = MarxPayment::where($whereArray)
      ->orderBy('date', 'ASC')
      ->take($request->input('number_row'))
      ->with('relationship')
      ->get();

    return Utils::camelCaseKeys($list->toArray());
  }

  public function getOnePayment(Request $request, $id)
  {
    $payment = MarxPayment::where('id', '=', $id)
      ->where('user_id', '=', $request->input('token_user_id'))
      ->with('relationship')
      ->with('reminder_date')
      ->first();

    if ($payment == null) {
      return Utils::errorResponseNotFound('payment');
    }

    return Utils::camelCaseKeys($payment->toArray());
  }

  public function createPayment(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'relationship.id' => 'required',
      'currency' => 'required',
      'title' => 'required',
      'amount' => 'required',
      'date' => 'required',
      'type' => 'required',
    ]);

    if ($validator->fails()) {
      return Utils::errorResponse($validator->errors()->all());
    }

    $payment = new MarxPayment;
    $payment->title = $request->input('title');
    $payment->relationship_id = $request->input('relationship.id');
    $payment->user_id = $request->input('token_user_id');
    $payment->date = $request->input('date');
    $payment->currency = $request->input('currency');
    $payment->amount = $request->input('amount');
    $payment->type = $request->input('type');

    if ($request->input('detail')) {
      $payment->detail = $request->input('detail');
    }
    $payment->save();

    return Utils::camelCaseKeys($payment->toArray());
  }

  public function refundedPayment(Request $request, $id)
  {
    $payment = MarxPayment::find($id);

    if ($payment == null) {
      return Utils::errorResponseNotFound('payment');
    }

    if ($payment->user_id != $request->input('token_user_id')) {
      return Utils::errorResponseNotBelongToYou('payment');
    }

    $payment->refunded = true;
    $payment->refunded_date = date("Y-m-d H:i:s");

    $payment->save();

    return Utils::camelCaseKeys($payment->toArray());
  }

  // Have it in a DB or simple string ?
  // For the moment, simple string
  public function getSuggestedCurrencies(Request $request) {
    // return MarxCurrency::all();
    return array('Euro', 'Dollar', 'Yen', 'Gold', 'Ecu', 'PokeDollar', 'Other');
  }

  







  // old method, keep for the moment

  public function getAllByUser(Request $request)
  {
    $whereArray = array(['user_id', '=', $request->input('token_user_id')]);
    if ($request->input('type') != null) {
      $whereArray[] = (['type', '=', $request->input('type')]);
    }
    if ($request->input('relationship_id') != null) {
      $whereArray[] = (['relationship_id', '=', $request->input('relationship_id')]);
    }
    if ($request->input('refunded') != null) {
      $refundBool;
      if ($request->input('refunded') == 'false') {
        $refundBool = 0;
      } else {
        $refundBool = 1;
      }
      $whereArray[] = (['refunded', '=', $refundBool]);
    }

    $list = MarxPayment::where($whereArray)
      ->orderBy('date', 'ASC')
      ->take($request->input('number_row'))
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
      ->with('reminder_date')
      ->first();

    if ($payment == null) {
      return Utils::errorResponseNotFound('payment');
    }

    return response()->json($payment);
  }

  public function create(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'relationship_id' => 'required',
      'user_currencies_id' => 'required',
      'title' => 'required',
      'amount' => 'required',
      'date' => 'required',
      'type' => 'required',
    ]);

    if ($validator->fails()) {
      return Utils::errorResponse($validator->errors()->all());
    }

    $payment = new MarxPayment;
    $payment->title = $request->input('title');
    $payment->relationship_id = $request->input('relationship_id');
    $payment->user_id = $request->input('token_user_id');
    $payment->date = $request->input('date');
    $payment->user_currencies_id = $request->input('user_currencies_id');
    $payment->amount = $request->input('amount');
    $payment->type = $request->input('type');

    if ($request->input('detail')) {
      $payment->detail = $request->input('detail');
    }
    $payment->save();

    return response()->json($payment);
  }

  public function update(Request $request, $id)
  {
    $validator = Validator::make($request->all(), [
      'relationship_id' => 'required',
      'user_currencies_id' => 'required',
      'title' => 'required',
      'amount' => 'required',
      'date' => 'required',
    ]);

    if ($validator->fails()) {
      return Utils::errorResponse($validator->errors()->all());
    }

    $payment = MarxPayment::find($id);
    if ($payment->user_id != $request->input('token_user_id')) {
      return Utils::errorResponseNotBelongToYou('payment');
    }

    $payment->title = $request->input('title');
    $payment->relationship_id = $request->input('relationship_id');
    $payment->date = $request->input('date');
    $payment->user_currencies_id = $request->input('user_currencies_id');
    $payment->amount = $request->input('amount');

    if ($request->input('detail')) {
      $payment->detail = $request->input('detail');
    }

    $payment->save();

    return response()->json($payment);
  }

  public function refunded(Request $request, $id)
  {
    $payment = MarxPayment::find($id);

    if ($payment == null) {
      return Utils::errorResponseNotFound('payment');
    }

    if ($payment->user_id != $request->input('token_user_id')) {
      return Utils::errorResponseNotBelongToYou('payment');
    }

    $payment->refunded = true;
    $payment->refunded_date = date("Y-m-d H:i:s");

    $payment->save();

    return response()->json($payment);
  }

  public function delete(Request $request, $id)
  {
    // TODO test delete cascade after
    $payment = MarxPayment::find($id);

    if ($payment == null) {
      return Utils::errorResponseNotFound('payment');
    }

    if ($payment->user_id != $request->input('token_user_id')) {
      return Utils::errorResponseNotBelongToYou('payment');
    }

    $payment->delete();
    return response()->json($payment);
  }

}
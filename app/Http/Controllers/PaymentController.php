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
      'getAllByUser', 'getOneByUser', 'delete', 'create', 'update'
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
      return array(
        'error' => true,
        'message' => $validator->errors()->all()
      );
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
      return array(
        'error' => true,
        'message' => $validator->errors()->all()
      );
    }

    $payment = MarxPayment::find($id);
    if ($payment->user_id != $request->input('token_user_id')) {
      return array(
        'error' => true,
        'message' => 'this payment didn\'t belong to you'
      );
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

  public function delete(Request $request, $id)
  {
    // TODO test delete cascade after
    $payment = MarxPayment::find($id);
    if ($payment == null) {
      return array(
        'error' => true,
        'message' => 'This payment didn\'t exist'
      );
    }
    if ($payment->user_id != $request->input('token_user_id')) {
      return array(
        'error' => true,
        'message' => 'this payment didn\'t belong to you',
      );
    }
    $payment->delete();
    return $payment;
  }

}
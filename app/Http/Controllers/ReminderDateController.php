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
use App\Models\MarxReminderDate;

use App\Utils\Utils;

class ReminderDateController extends Controller
{

  public function __construct()
  {
    //To have security
    $this->middleware('auth', ['only' => [
      'getAllByUser',
      'create',
      'delete'
    ]]);
  }

  public function getAllByUser(Request $request)
  {
    $list = MarxReminderDate::whereHas('payment', function ($query) use ($request) {
      $query->where('refunded', '=', '0')
        ->where('user_id', '=', $request->input('token_user_id'));
    })
      ->with('payment')
      ->get();

    return $list;
  }

  public function delete(Request $request, $id)
  {
    // TODO test delete cascade after
    $reminderDate = MarxReminderDate::with('payment')->find($id);
    if ($reminderDate == null) {
      return Utils::errorResponseNotFound('reminder date');
    }
    if ($reminderDate->payment->user_id != $request->input('token_user_id')) {
      return Utils::errorResponseNotBelongToYou('reminder date');
    }
    $reminderDate->delete();
    return $reminderDate;
  }

  public function create(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'payment_id' => 'required',
      'date' => 'required',
    ]);

    if ($validator->fails()) {
      return Utils::errorResponse($validator->errors()->all());
    }

    $reminderDate = new MarxReminderDate;
    $reminderDate->payment_id = $request->input('payment_id');
    $reminderDate->date = $request->input('date');

    $reminderDate->save();

    return response()->json($reminderDate);
  }

}
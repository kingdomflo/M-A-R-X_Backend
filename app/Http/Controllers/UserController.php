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

use App\Utils\Utils;
use App\Models\Entity\UserRelationshipType;

use Auth0\SDK\API\Management;
use Auth0\SDK\Auth0;

class UserController extends Controller
{

  public function __construct()
  {
    $this->middleware('auth0', ['only' => [
      'login'
    ]]);
  }

  // TODO verify that he come from my auth0 account!
  // TODO rework with the new model
  // TODO add at the create all the relationship type
  public function login(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'user_id' => 'required',
      'name' => 'required'
    ]);

    if ($validator->fails()) {
      return Utils::errorResponse($validator->errors()->all());
    }

    $user;
    $userLink = MarxUser::where('auth0_id', '=', $request->input('user_id'))
      ->take(1)
      ->get();

    if (count($userLink) == 0) {
      $user = new MarxUser;
      $user->auth0_id = $request->input('user_id');
      $user->name = $request->input('name');
      $user->save();

      $relationshipType = MarxRelationshipType::all();
      foreach($relationshipType as &$item) {
        $userRelationshipType = new MarxUserRelationshipType;
        $userRelationshipType->user_id = $user->id;
        $userRelationshipType->relationship_type_id = $item->id;
        $userRelationshipType->save();
      }

    } else {
      $user = $userLink[0];
    }

    $signer = new Sha256();
    $token = (new Builder())
      ->set('id', $user->id)
      ->set('date', date("Y-m-d H:i:s"))
      ->sign($signer, env('JWT_TOKEN_SIGN'))
      ->getToken();

    return response()->json(['apiToken' => $token->__toString()]);
  }

}
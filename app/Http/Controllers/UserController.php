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

class UserController extends Controller
{

  public function __construct()
  {
    //To have security
    $this->middleware('auth', ['only' => [
      'getAll', 'getAllRelationshipType', 'update', 'addRelationshipType', 'updateName'
    ]]);
  }

  public function login(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'user_id' => 'required',
      'email' => 'required',
      'name' => 'required'
    ]);
    if ($validator->fails()) {
      return array(
        'error' => true,
        'message' => $validator->errors()->all()
      );
    }

    $user;
    $userLink = MarxUser::where('auth0_id', '=', $request->input('user_id'))->where('email', '=', $request->input('email'))->take(1)->get();
    if (count($userLink) == 0) {
      $user = new MarxUser;
      $user->auth0_id = $request->input('user_id');
      $user->email = $request->input('email');
      $user->name = $request->input('name');
      $user->save();
    } else {
      $user = $userLink[0];
    }

    $signer = new Sha256();
    $token = (new Builder())->set('id', $user->id)->set('date', date("Y-m-d H:i:s"))->sign($signer, env('JWT_TOKEN_SIGN'))->getToken();
    return response()->json(['Api-Token' => $token->__toString()]);
  }

  public function getAll()
  {
    $liste = MarxUser::all();
    return $liste;
  }

  public function updateName(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'name' => 'required'
    ]);
    if ($validator->fails()) {
      return array(
        'error' => true,
        'message' => $validator->errors()->all()
      );
    }

    $user = MarxUser::find($request->input('token_user_id'));
    $user->name = $request->name;
    $user->save();
    return response()->json($user);
  }

  public function getAllRelationshipType(Request $request)
  {
    $list = MarxUser::find($request->input('token_user_id'))->marx_relationship_type()->get();
    return $list;
  }

  public function addRelationshipType(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'name' => 'required'
    ]);

    if ($validator->fails()) {
      return array(
        'error' => true,
        'message' => $validator->errors()->all()
      );
    }

    $relationshipTypeLink = MarxRelationshipType::where('name', '=', $request->input('name'))->take(1)->get();
    if (count($relationshipTypeLink) > 0) {
      $relationshipType = $relationshipTypeLink[0];
      $verifyPresent = MarxUserRelationshipType::where('user_id', '=', $request->input('token_user_id'))->where('relationship_type_id', '=', $relationshipType->id)->take(1)->get();
      if (count($verifyPresent) > 0) {
        return array(
          'error' => true,
          'message' => ['relationship type already present']
        );
      }
    } else {
      $relationshipType = new MarxRelationshiptype;
      $relationshipType->name = $request->input('name');
      $relationshipType->save();
    }

    $link = new MarxUserRelationshipType;
    $link->user_id = $request->input('token_user_id');
    $link->relationship_type_id = $relationshipType->id;
    $link->save();

    return response()->json($relationshipType);
  }

  public function update(Request $request)
  {

  }

}
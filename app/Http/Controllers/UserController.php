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

  public function login()
  {
    $signer = new Sha256();
    $token = (new Builder())->set('id', 1)->sign($signer, env('JWT_TOKEN_SIGN'))->getToken();
    return response()->json(['Api-Token' => $token->__toString()]);
  }

  public function getAll()
  {
    $liste = MarxUser::all();
    return $liste;
  }

  public function getAllRelationshipType(Request $request, $id)
  {
    $list = MarxUser::find($id)->marx_relationship_type()->get();
    return $list;
  }

  public function addRelationshipType(Request $request, $id)
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
    } else {
      $relationshipType = new MarxRelationshiptype;
      $relationshipType->name = $request->input('name');
      $relationshipType->save();
    }

    $link = new MarxUserRelationshipType;
    $link->user_id = $id;
    $link->relationship_type_id = $relationshipType->id;
    $link->save();

    return response()->json($relationshipType);
  }

  public function update(Request $request)
  {

  }

}
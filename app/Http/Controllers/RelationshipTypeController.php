<?php

namespace App\Http\Controllers;

use Illuminate\Hashing\BcryptHasher;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

use App\MarxRelationship;
use App\MarxRelationshipType;
use App\MarxUserRelationshipType;
use App\MarxUser;

class RelationshipTypeController extends Controller
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
    $list = MarxRelationshipType::all();
    return $list;
  }


  public function create(Request $request)
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

    $relationship = new MarxRelationshiptype;
    $relationship->name = $request->input('name');
    $relationship->save();

    return array($relationship);
  }

}
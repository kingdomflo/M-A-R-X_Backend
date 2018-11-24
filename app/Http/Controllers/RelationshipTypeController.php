<?php

namespace App\Http\Controllers;

use Illuminate\Hashing\BcryptHasher;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

use App\Models\MarxRelationship;
use App\Models\MarxRelationshipType;
use App\Models\MarxUserRelationshipType;
use App\Models\MarxUser;

use App\Utils\Utils;

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
    if ($request->input('name') != null) {
      $list = MarxRelationshipType::where('name', 'like', '%' . $request->input('name') . '%')->get();
    } else {
      $list = MarxRelationshipType::all();
    }
    return $list;
  }

  public function create(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'name' => 'required'
    ]);

    if ($validator->fails()) {
      return Utils::errorResponse($validator->errors()->all());
    }

    $relationship = new MarxRelationshiptype;
    $relationship->name = $request->input('name');
    $relationship->save();

    return response()->json($relationship);
  }

}
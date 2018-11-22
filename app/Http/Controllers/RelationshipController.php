<?php

namespace App\Http\Controllers;

use Illuminate\Hashing\BcryptHasher;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

use App\Models\MarxRelationship;
use App\Models\MarxUser;

use App\Utils\Utils;

class RelationshipController extends Controller
{

  public function __construct()
  {
    //To have security
    $this->middleware('auth', ['only' => [
      'getAll',
      'create',
      'getOne',
      'update',
      'delete'
    ]]);
  }

  public function getAll(Request $request)
  {
    $list = MarxRelationship::whereHas('user_relationship_type', function ($query) use ($request) {
      $query->where('user_id', '=', $request->input('token_user_id'));
    })
      ->with('user_relationship_type')->get();

    return $list;
  }

  public function getOne(Request $request, $id)
  {
    $relationship = MarxRelationship::where('id', '=', $id)
      ->with('user_relationship_type')
      ->first();
    return response()->json($relationship);
  }

  public function create(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'name' => 'required',
      'relationship_type_id' => 'required',
    ]);

    if ($validator->fails()) {
      return Utils::errorResponse($validator->errors()->all());
    }

    $relationship = new MarxRelationship;
    $relationship->name = $request->input('name');
    $relationship->user_relationship_type_id = $request->input('relationship_type_id');
    $relationship->save();

    return response()->json($relationship);
  }

  public function update(Request $request, $id)
  {
    $validator = Validator::make($request->all(), [
      'name' => 'required',
      'relationship_type_id' => 'required',
    ]);

    if ($validator->fails()) {
      return Utils::errorResponse($validator->errors()->all());
    }

    $relationship = MarxRelationship::find($id);
    if ($relationship->user_id != $request->input('token_user_id')) {
      // return array(
      //   'error' => true,
      //   'message' => 'this relation didn\'t belong to you'
      // );
      return Utils::errorResponse(['This relation didn\'t belong to you']);
    }
    $relationship->name = $request->input('name');
    $relationship->user_relationship_type_id = $request->input('relationship_type_id');
    $relationship->save();

    return response()->json($relationship);
  }

  public function delete(Request $request, $id)
  {
    // TODO test delete cascade after
    $relationship = MarxRelationship::find($id);
    if ($relationship == null) {
      // return array(
      //   'error' => true,
      //   'message' => 'This relationship didn\'t exist'
      // );
      return Utils::errorResponse(['This relationship didn\'t exist']);
    }
    if ($relationship->user_id != $request->input('token_user_id')) {
      // return array(
      //   'error' => true,
      //   'message' => 'this relation didn\'t belong to you'
      // );
      return Utils::errorResponse(['This relation didn\'t belong to you']);
    }
    $relationship->delete();
    return response()->json($relationship);
  }

}
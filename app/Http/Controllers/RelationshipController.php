<?php

namespace App\Http\Controllers;

use Illuminate\Hashing\BcryptHasher;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

use App\MarxRelationship;
use App\MarxUser;

class RelationshipController extends Controller
{

  public function __construct()
  {
    //To have security
    $this->middleware('auth', ['only' => [
      'getAll', 'create', 'getOne', 'update', 'delete'
    ]]);
  }

  public function getAll(Request $request)
  {
    $list = MarxRelationship::where('user_id', '=', $request->input('token_user_id'))->with('user_relationship_type')->get();
    return $list;
  }

  public function getOne(Request $request, $id)
  {
    $relationship = MarxRelationship::where('id', '=', $id)->with('user_relationship_type')->get();
    return $relationship;
  }

  public function create(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'name' => 'required',
      'relationship_type_id' => 'required',
    ]);

    if ($validator->fails()) {
      return array(
        'error' => true,
        'message' => $validator->errors()->all()
      );
    }

    $relationship = new MarxRelationship;
    $relationship->name = $request->input('name');
    $relationship->user_relationship_type_id = $request->input('relationship_type_id');
    $relationship->user_id = $request->input('token_user_id');
    $relationship->save();

    return array($relationship);
  }

  public function update(Request $request, $id)
  {
    $validator = Validator::make($request->all(), [
      'name' => 'required',
      'relationship_type_id' => 'required',
    ]);

    if ($validator->fails()) {
      return array(
        'error' => true,
        'message' => $validator->errors()->all()
      );
    }

    $relationship = MarxRelationship::find($id);
    if($relationship->user_id != $request->input('token_user_id')) {
      return array(
        'error' => true,
        'message' => 'this relation didn\'t belong to you'
      );
    }
    $relationship->name = $request->input('name');
    $relationship->user_relationship_type_id = $request->input('relationship_type_id');
    $relationship->save();

    return $relationship;
  }

  public function delete(Request $request, $id)
  {
    // TODO test delete cascade after
    $relationship = MarxRelationship::find($id);
    if($relationship->user_id != $request->input('token_user_id')) {
      return array(
        'error' => true,
        'message' => 'this relation didn\'t belong to you'
      );
    }
    $relationship->delete();
    return $relationship;
  }

}
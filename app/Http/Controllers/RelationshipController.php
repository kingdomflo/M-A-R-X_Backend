<?php

namespace App\Http\Controllers;

use Illuminate\Hashing\BcryptHasher;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

use App\Models\MarxRelationship;
use App\Models\MarxUser;

use App\Utils\Utils;
use App\Jobs\RelationshipMapper;

use App\Models\Entity\Relationship;
use App\Models\MarxRelationshipType;

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
      'delete',

      'getAllRelationshipType',
      'getAllRelationship',
      'createRelationship',
      'getOneRelationship'
    ]]);
  }

  // rework the route and method
  // TODO rework with model

  public function getAllRelationshipType(Request $request)
  {
    return Utils::camelCaseKeys(MarxRelationshipType::all()->toArray());
  }

  public function getAllRelationship(Request $request)
  {
    $list = MarxRelationship::whereHas('user_relationship_type', function ($query) use ($request) {
      $query->where('user_id', '=', $request->input('token_user_id'));
    })->with('user_relationship_type')->get();

    return Utils::camelCaseKeys($list->toArray());
  }  

  // TODO with real object
  public function createRelationship(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'name' => 'required',
      'userRelationshipTypeId' => 'required',
    ]);

    if ($validator->fails()) {
      return Utils::errorResponse($validator->errors()->all());
    }

    $relationship = new MarxRelationship;
    $relationship->name = $request->input('name');
    $relationship->user_relationship_type_id = $request->input('userRelationshipTypeId');
    $relationship->save();

    return Utils::camelCaseKeys($relationship->toArray());
  }

  public function getOneRelationship(Request $request, $id)
  {
    $relationship = MarxRelationship::where('id', '=', $id)
      ->with('user_relationship_type')
      ->first();

    if ($relationship == null) {
      return Utils::errorResponseNotFound('relationship');
    }
    return Utils::camelCaseKeys($relationship->toArray());
  }









  // old method, keep for the moment

  public function getAll(Request $request)
  {
    $list = MarxRelationship::whereHas('user_relationship_type', function ($query) use ($request) {
      $query->where('user_id', '=', $request->input('token_user_id'));
    })
      ->with('user_relationship_type')->get();

    //return Relationship::map_array($list);
    return $list;
  }

  public function getOne(Request $request, $id)
  {
    $relationship = MarxRelationship::where('id', '=', $id)
      ->with('user_relationship_type')
      ->first();

    if ($relationship == null) {
      return Utils::errorResponseNotFound('relationship');
    }
    //return response()->json(Relationship::map_single($relationship));
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

    if ($relationship == null) {
      return Utils::errorResponseNotFound('relationship');
    }

    if ($relationship->user_relationship_type->user_id != $request->input('token_user_id')) {
      return Utils::errorResponseNotBelongToYou('relationship');
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
      return Utils::errorResponseNotFound('relationship');
    }

    if ($relationship->user_id != $request->input('token_user_id')) {
      return Utils::errorResponseNotBelongToYou('relationship');
    }

    $relationship->delete();
    return response()->json($relationship);
  }

}
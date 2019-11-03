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
use App\Models\MarxRelationshipTypeTranslation;
use App\Models\MarxUserRelationshipType;

class RelationshipController extends Controller
{

  public function __construct()
  {
    //To have security
    $this->middleware('auth', ['only' => [
      'getAllRelationshipType',
      'getAllRelationship',
      'createRelationship',
      'getOneRelationship',
      'changeUserRelationshipTypeDelay',
      'updateRelationship',
      'deleteOneRelationship'
    ]]);
  }

  // Can better call to multilangue ?
  public function getAllRelationshipType(Request $request)
  {
    $list = MarxUserRelationshipType::where('user_id', '=', $request->input('token_user_id'))
      ->with('relationship_type')->get();

    if($request->header('content-language') != 'en') {
      foreach($list->toArray() as $key => $item) {
        $list[$key]['relationship_type']['name'] = Utils::translateRelationshipType($request->header('content-language'), $item['relationship_type'])['name'];
      }
    }

    return Utils::camelCaseKeys($list->toArray());
  }

  public function getAllRelationship(Request $request)
  {
    $list = MarxRelationship::whereHas('user_relationship_type', function ($query) use ($request) {
      $query->where('user_id', '=', $request->input('token_user_id'));
      })->with('user_relationship_type')->get();

    if($request->header('content-language') != 'en') {
      foreach($list->toArray() as $key => $item) {
        $list[$key]['user_relationship_type']['relationship_type']['name'] = Utils::translateRelationshipType($request->header('content-language'), $item['user_relationship_type']['relationship_type'])['name'];
      }
    }
    
    return Utils::camelCaseKeys($list->toArray());
  } 

  // TODO block duplicate
  public function createRelationship(Request $request)
  {
    $validator = Validator::make($request->all(), [
    'name' => 'required',
    'userRelationshipType.id' => 'required',
    ]);

    if ($validator->fails()) {
      return Utils::errorResponse($validator->errors()->all());
    }

    $relationship = new MarxRelationship;
    $relationship->name = $request->input('name');
    $relationship->user_relationship_type_id = $request->all()['userRelationshipType']['id'];
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

    if($request->header('content-language') != 'en') {
      $relationship['user_relationship_type']['relationship_type']['name'] = Utils::translateRelationshipType($request->header('content-language'), $relationship['user_relationship_type']['relationship_type'])['name'];
    }

    return Utils::camelCaseKeys($relationship->toArray());
  }

  public function changeUserRelationshipTypeDelay(Request $request, $id) {
    $validator = Validator::make($request->all(), [
      'reminderDate' => 'required',
    ]);

    if ($validator->fails()) {
      return Utils::errorResponse($validator->errors()->all());
    }

    $userRelationshipType = MarxUserRelationshipType::find($id);

    if ($userRelationshipType == null) {
      return Utils::errorResponseNotFound('relationship type');
    }

    $userRelationshipType->reminder_date = $request->input('reminderDate');
    $userRelationshipType->save();

    return Utils::camelCaseKeys($userRelationshipType->toArray());
  }

  // TODO block duplicate
  public function updateRelationship(Request $request, $id)
  {
    $validator = Validator::make($request->all(), [
      'name' => 'required',
      'userRelationshipType.id' => 'required',
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
    $relationship->user_relationship_type_id = $request->all()['userRelationshipType']['id'];
    $relationship->save();

    return Utils::camelCaseKeys($relationship->toArray());
  }

  public function deleteOneRelationship(Request $request, $id)
  {
    $relationship = MarxRelationship::find($id);

    if ($relationship == null) {
      return Utils::errorResponseNotFound('relationship');
    }

    $relationship->delete();
    return response()->json($relationship);
  }

}
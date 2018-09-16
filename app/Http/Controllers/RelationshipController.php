<?php

namespace App\Http\Controllers;

use Illuminate\Hashing\BcryptHasher;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

use App\MarxRelationship;

class RelationshipController extends Controller
{

  public function getAll()
  {
    $liste = MarxRelationship::all();
    return $liste;
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

    $relationship = new MarxRelationship;
    $relationship->name = $request->input('name');
    $relationship->save();

    return array($relationship);
  }

}
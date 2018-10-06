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

class UserController extends Controller
{

  public function login()
  {
    $signer = new Sha256();
    $token = (new Builder())->set('id', 145)->sign($signer, env('JWT_TOKEN_SIGN'))->getToken();
    return response()->json(['Api-Token' => $token->__toString()]);
  }

  public function getAll()
  {
    $liste = MarxUser::all();
    return $liste;
  }

  public function update(Request $request)
  {

  }

}
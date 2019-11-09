<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Factory as Auth;

use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Key;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Hmac\Rs256;

use Auth0\SDK\JWTVerifier;
use Auth0\SDK\Exception\InvalidTokenException;
use Auth0\SDK\Exception\CoreException;

class Auth0
{
    /**
     * The authentication guard factory instance.
     *
     * @var \Illuminate\Contracts\Auth\Factory
     */
    protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Contracts\Auth\Factory  $auth
     * @return void
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        // TODO remove that outside the test
        // return $next($request);

        $header = $request->header('it-this-my-auth');
        if ($header) {
            $signer = new Sha256();
            $token = (new Parser())->parse((string)$header);
            if ($token->verify($signer, env('JWT_TOKEN_SIGN'))) {
                if ($token->getClaim('user_id') != $request->input('user_id') ||
                    $token->getClaim('name') != $request->input('name')) {
                    return response(array(
                        'error' => true,
                        'message' => ['The json and the token dont match']
                    ), 401);
                }
                return $next($request);
            } else {
                return response(array(
                    'error' => true,
                    'message' => ['You are not comming from the right Auth0 service']
                ), 401);
            }
        }
        return response(array(
            'error' => true,
            'message' => ['You must prove that you come from an Auth0 service']
        ), 401);
    }
}

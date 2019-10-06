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
        return $next($request);

        // $header = $request->header('it-this-my-auth');
        // $idToken = $request->header('idToken');

        // $config = [
        //     // Array of allowed algorithms; never pass more than what is expected.
        //     'supported_algs' => ['RS256'],
        //     // Array of allowed "aud" values.
        //     'valid_audiences' => [ env('AUTH0_CLIENT_ID') ],
        // ];
        // $config['authorized_iss'] = [ 'https://'.env('AUTH0_DOMAIN').'/' ];

        // try {
        //     $verifier = new JWTVerifier($config);
        //     $decoded_token = $verifier->verifyAndDecode($idToken);
        //     // var_dump($decoded_token);
        //     return $next($request);
        // } catch(\Exception $e) {
        //     return response(array(
        //         'error' => true,
        //         'message' => ['You must prove that you come from an Auth0 service']
        //     ), 401);
        // }
 
        
        // $signer = new Sha256();
        // $token = (new Parser())->parse((string)$idToken);
        // if ($token->verify($signer, 'AjAOmRFRqxRQIS6XZBbaeYKNKKhe55zU')) {
        //     var_dump('ok');
        // } else {
        //     var_dump('nok');
        // }

        // var_dump($token->getClaim('nickname'));

        if ($header) {
            // $signer = new Sha256();
            // $token = (new Parser())->parse((string)$header);
            // if ($token->verify($signer, env('JWT_TOKEN_SIGN'))) {

            //     if ($token->getClaim('user_id') != $request->input('user_id') ||
            //         $token->getClaim('name') != $request->input('name')) {
            //         return response(array(
            //             'error' => true,
            //             'message' => ['The json and the token dont match']
            //         ), 401);
            //     }

            //     return $next($request);
            // } else {
            //     return response(array(
            //         'error' => true,
            //         'message' => ['You are not comming from the right Auth0 service']
            //     ), 401);
            // }
            
            if($header == env('JWT_TOKEN_SIGN')) {
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

<?php

namespace App\Providers;

use App\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\GenericUser;

use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Hmac\Sha256;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot()
    {
        // Here you may define how you wish users to be authenticated for your Lumen
        // application. The callback which receives the incoming request instance
        // should return either a User instance or null. You're free to obtain
        // the User instance via an API token or any other method necessary.

        $this->app['auth']->viaRequest('api', function ($request) {

            $header = $request->header('Api-Token');

            if ($header) {

                $signer = new Sha256();
                $token = (new Parser())->parse((string)$header);
                if ($token->verify($signer, env('JWT_TOKEN_SIGN'))) {
                    $request->request->add(['token_user_id'=>$token->getClaim('id')]);
                    return new GenericUser(['id' => $token->getClaim('id'), 'name' => 'Taylor']);
                } else {
                    return null;
                }
            }

            return null;
        });
    }
}

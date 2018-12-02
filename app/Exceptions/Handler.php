<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Illuminate\Http\Exception\HttpResponseException;
use Illuminate\Http\Response;
use Illuminate\Database\QueryException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        // var_dump($e->getPrevious()->errorInfo[1]);
        // var_dump($e instanceof QueryException);

        // if (env('APP_DEBUG')) {

        //     return parent::render($request, $e);
        // }

        if ($e instanceof HttpResponseException) {
            $status = Response::HTTP_INTERNAL_SERVER_ERROR;
            $e = $e->getMessage();
        } elseif ($e instanceof MethodNotAllowedHttpException) {
            $status = Response::HTTP_METHOD_NOT_ALLOWED;
            $e = "You aren't authorize to acces to this method";
        } elseif ($e instanceof NotFoundHttpException) {
            $status = Response::HTTP_NOT_FOUND;
            $e = "This route don't exist";
        } elseif ($e instanceof AuthorizationException) {
            $status = Response::HTTP_FORBIDDEN;
            $e = "You aren't authorize to acces to this route";
        } elseif ($e instanceof \Dotenv\Exception\ValidationException && $e->getResponse()) {
            $status = Response::HTTP_BAD_REQUEST;
            $e = "Bad validation";
        } elseif ($e instanceof QueryException) {
            $status = 406;
            //$e = $e->getMessage();
            //$e = $e->getPrevious()->getMessage();
            //$e = $e->getPrevious()->errorInfo[1];
            if ($e->getPrevious()->errorInfo[1] == 1062) {
                $e = "This entry already exist";
            } else if ($e->getPrevious()->errorInfo[1] == 1451) {
                $e = "You can't delete this item because it's belong to other items";
            } else {
                $e = "There is an error with the database";
            }
        } else {
            $status = Response::HTTP_INTERNAL_SERVER_ERROR;
            $e = "There is a internal error, please contact support";
        }
        return response()->json([
            'success' => false,
            'status' => $status,
            'message' => [$e]
        ], $status);
    }
}

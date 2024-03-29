<?php

namespace App\Exceptions;

use App\Traits\ResponseHelper;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    use ResponseHelper;

    const FOREIGN_KEY_VIOLATION_CODE = 1451;
    const COLUMN_NOT_FOUND_VIOLATION_CODE = 1054;
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e)
    {
        if($e instanceof ValidationException) {
            return $this->convertValidationExceptionToResponse($e, $request);
        }
        if($e instanceof ModelNotFoundException) {

            $modelName = class_basename($e->getModel());
            return $this->errorResponse("$modelName does not exists with the specified key", 404);
        }

        if($e instanceof AuthenticationException) {
            return $this->unauthenticated($request, $e);
        }

        if($e instanceof AuthorizationException) {
            return $this->errorResponse($e->getMessage(), 403);
        }

        if($e instanceof NotFoundHttpException) {
            return $this->errorResponse("The specified URL not found!", 404);
        }

        if($e instanceof MethodNotAllowedHttpException) {
            return $this->errorResponse("The specified HTTP method for the request not found!", 405);
        }

        if($e instanceof HttpException) {
            return $this->errorResponse($e->getMessage(), $e->getStatusCode());
        }

        if($e instanceof QueryException) {
            $errorCode = $e->errorInfo[1];
            if($errorCode === self::FOREIGN_KEY_VIOLATION_CODE) {
                return $this->errorResponse("Cannot remove this resource permanently, as it has some other resourced related to it.", 409);
            }

            if($errorCode === self::COLUMN_NOT_FOUND_VIOLATION_CODE) {
                return $this->errorResponse("Column used in specified operation not found!", 409);
            }
        }

        if(config('app.debug')) {
            return parent::render($request, $e);
        }

        return $this->errorResponse("Server Error!", 500);
    }

    protected function convertValidationExceptionToResponse(ValidationException $e, $request): JsonResponse
    {
        return $this->errorResponse($e->errors(), 422);
    }

    protected function unauthenticated($request, AuthenticationException $exception): JsonResponse
    {
        return $this->errorResponse("Unauthenticated!", 401);
    }
}

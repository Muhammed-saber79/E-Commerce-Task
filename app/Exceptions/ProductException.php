<?php

namespace App\Exceptions;

use App\Traits\GeneralTrait;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProductException extends Exception
{
    use GeneralTrait;
    protected $code = 422;

    public function render($request, $exception)
    {
        if ($exception instanceof ModelNotFoundException || $exception instanceof NotFoundHttpException) {
            return $this->returnError(404, $this->getMessage());
        }

        return $this->returnError($this->code, $this->getMessage());
    }
}

<?php

namespace App\Exceptions;

use App\Traits\GeneralTrait;
use Exception;
use Illuminate\Http\JsonResponse;

class UserException extends Exception
{
    use GeneralTrait;
    protected $code = 422;

    public function render($request)
    {
        return $this->returnError($this->code, $this->getMessage());
    }
}

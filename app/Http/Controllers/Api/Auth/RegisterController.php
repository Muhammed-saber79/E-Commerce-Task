<?php

namespace App\Http\Controllers\Api\Auth;

use App\Exceptions\UserException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\RegisterRequest;
use App\Http\Resources\Api\UserResource;
use App\Models\User;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    use GeneralTrait;

    public function register(RegisterRequest $request)
    {
        try {
            $user = User::create($request->validated());
            if (!$user) {
                throw new UserException('Failed to register user. Please try again later.');
            }
        } catch (UserException $e) {
            return $this->returnError(500, $e->getMessage(), null);
        } catch (\Exception $e) {
            return $this->returnError(500, 'An error occurred. Please try again later.', null);
        }

        return $this->returnData(201, 'You registered successfully.', new UserResource($user));
    }
}

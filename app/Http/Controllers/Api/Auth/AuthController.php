<?php

namespace App\Http\Controllers\Api\Auth;

use App\Exceptions\UserException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Models\User;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    use GeneralTrait;

    public function login(LoginRequest $request)
    {
        try {
            if (!$token = auth('api')->attempt(['email' => $request->email, 'password' => $request->password])) {
                throw new UserException('Invalid credentials. Please try again later.');
            }
        } catch (UserException $e) {
            return $this->returnError(401, $e->getMessage(), null);
        } catch (\Exception $e) {
            return $this->returnError(500, 'An error occurred. Please try again later.', null);
        }

        $user = User::where('email', $request->email)->first();
        return $this->returnData(200, 'You logged-in successfully.', [
            'token' => $token,
            'token_type' => 'bearer',
        ]);
    }

    public function logout()
    {
        auth()->logout();

        return $this->returnSuccess(200, 'Successfully logged out');
    }
}

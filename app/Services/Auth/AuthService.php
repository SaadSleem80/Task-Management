<?php 

namespace App\Services\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\HttpException;

class AuthService
{
    public function login($request)
    {
        if (! Auth::attempt(['email' => $request['email'], 'password' => $request['password']])) 
            throw new HttpException(401, 'Invalid credentials');

        /** @var User $user */
        $user = Auth::user();

        $token = $user->createToken('authToken')->plainTextToken;

        return [
            'user' => $user,
            'token' => $token
        ];
    }

    public function logout()
    {
        /** @var User $user */
        $user = Auth::user();
        $user->tokens()->delete();    
    }
}

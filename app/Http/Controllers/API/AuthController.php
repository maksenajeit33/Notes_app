<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Traits\sendMessage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    use sendMessage;

    // REGISTER THE USER
    public function register(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'c_password' => 'required|same:password'
        ]);

        // Check from errors in the request
        if($validator->fails())
            return $this->sendError('Please validate the errors', $validator->errors());

        // Create the user and the token
        $value = $request->all();
        $value['password'] = Hash::make($value['password']);
        $user = User::create($value);
        $result['name'] = $user->name;
        $result['email'] = $user->email;
        $result['token'] = $user->createToken('user@user')->accessToken;

        // Send the response
        return $this->sendResponse($result, 'Register successful!');

    }

    // LOGIN THE USER
    public function login(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:8'
        ]);

        // Check from errors in the request
        if($validator->fails())
            return $this->sendError('Please Validate the errors', $validator->errors());

        // Read the data from database
        $value = $request->all();
        $user = User::where('email', $value['email'])->first();

        // Check from the password
        if(!Hash::check($value['password'], $user->password))
            return $this->sendError('Password incorrect');

        // Create the token
        $result['name'] = $user->name;
        $result['email'] = $user->email;
        $result['token'] = $user->createToken('user@user')->accessToken;

        // Send the response
        return $this->sendResponse($result, 'Login successful!');
    }

    // LOGOUT THE USER
    public function logout(Request $request)
    {
        // Revoke access token
        $request->user()->token()->revoke();

        // Revoke all of the token's refresh tokens
        $refreshTokenRepository = app('Laravel\Passport\RefreshTokenRepository');
        $refreshTokenRepository->revokeRefreshTokensByAccessTokenId($request->user()->token()->id);

        return $this->sendMessageResponse('Logout successful!');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     * @throws AuthenticationException
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        if($validator->fails())
            return response()->json($validator->errors()->all(), Response::HTTP_UNPROCESSABLE_ENTITY);

        $credentials = request(['email', 'password']);
        if(!Auth::attempt($credentials))
            throw new AuthenticationException();

        $user = $request->user();

        $tokenResult = $user->createToken('Personal Access Token');

        $data["user"] = $user;
        $data["token_type"] = 'Bearer';
        $data["access_token"] = $tokenResult->accessToken;

        return response()->json($data, Response::HTTP_OK);
    }

    public function signup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')],
            'password' => ['required', 'string', 'min:8'],
            'name' => ['required', 'string', 'max:255'],
            'phone_number' => ['required', 'numeric'],
        ]);

        if($validator->fails())
            return $validator->errors()->all();

        $request['password'] = Hash::make($request['password']);

        $user = User::query()->create([
            'email' => $request->email,
            'password' => $request->password,
            'name' => $request->name,
            'phone_number' => $request->phone_number,
        ]);

        $tokenResult = $user->createToken('Personal Access Token');

        $data["user"] = $user;
        $data["token_type"] = 'Bearer';
        $data["access_token"] = $tokenResult->accessToken;

        return response()->json($data, Response::HTTP_OK);
    }

    /**
     * Logout user (Revoke the token)
     *
     * @return [string] message
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    /**
     * Get the authenticated User
     *
     * @return [json] user object
     */
    public function user(Request $request)
    {
        return response()->json($request->user());
    }
}

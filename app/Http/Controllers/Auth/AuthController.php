<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;

class AuthController extends Controller
{
    /**
     * User registration.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|unique:users,email|email',
            'password' => 'required',
            'phone' => 'required|regex:^[\d\+\-\(\) ]+$'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'phone' => $request->phone
        ]);

        if(!$token = auth()->attempt($request->only(['email', 'password'])))
            {
                return abort(401);
            }

        return (new UserResource($user))
            ->additional([
               'meta' => [
                   'token' => $token
             ]
        ]);
    }

    /**
     * User login
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required'
        ]);

        if(!$token = auth()->attempt($request->only(['email', 'password'])))
        {
            return response()->json([
                'errors' => [
                    'email' => ['There is something wrong! We could not verify details']
            ]], 422);
        }

        return (new UserResource($request->user()))
            ->additional([
                'meta' => [
                    'token' => $token
                ]
            ]);
    }

    /**
     * Return user data as API resource
     *
     * @param  \Illuminate\Http\Request  $request
     * @return App\Http\Resources\UserResource
     */
    public function user(Request $request)
    {
        return new UserResource($request->user());
    }

    /**
     * User logout
     */
    public function logout()
    {
        auth()->logout();
    }
}
